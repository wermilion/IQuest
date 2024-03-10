import { defineStore } from 'pinia'

import type { AxiosError } from 'axios'

export enum EApiStatus {
  NONE = 'NONE',
  PENDING = 'PENDING',
  FULFILLED = 'FULFILLED',
  REJECTED = 'REJECTED',
}

//* --- State ----------------------------------------------- *//
interface IRequestMetaState {
  _status: Map<string, EApiStatus>
  _error: Map<string, RequestMetaError>
}

//* --- Store ----------------------------------------------- *//
export const useRequestMeta = defineStore('requestMeta', {
  state: (): IRequestMetaState => ({
    _status: new Map(),
    _error: new Map(),
  }),

  actions: {
    _setLoading(key: string, value: EApiStatus) {
      this._status.set(key, value)
    },

    _setError(key: string, value: RequestMetaError) {
      value ? this._error.set(key, value) : this._error.delete(key)
    },

    async requestMetaWrapper<T = boolean>(payload: IRequestMetaWrapperPayload<T>): Promise<T> {
      const { key, callback, successCallback, errorCallback, attemptCounts } = payload

      this._setLoading(key, EApiStatus.PENDING)
      this._setError(key, null)

      const { result, errors } = await this.retryAsync(callback, attemptCounts ?? 2)

      await (result && !errors
        ? successCallback?.({ data: result as Awaited<T>, state: this.$state })
        : errorCallback?.({ errors: errors as Error | AxiosError, state: this.$state }))

      this._setLoading(key, result ? EApiStatus.FULFILLED : EApiStatus.REJECTED)
      this._setError(key, errors)

      return (result ?? false) as Awaited<T>
    },
    async retryAsync<T>(
      callback: (payload: ICallback) => T,
      attemptCounts: number,
    ): Promise<IRetryResult<T>> {
      let errors: Error | AxiosError | null = null

      for (let i = 0; i < attemptCounts; i++) {
        try {
          const result = ((await callback({ state: this.$state })) ?? true) as Awaited<T>

          return { result, errors }
        }
        catch (e) {
          errors = e as Error | AxiosError
        }
      }

      return { errors }
    },
    checkAnyIsLoading(keys: string[]): boolean {
      return keys.some(s => this._status.get(s) === EApiStatus.PENDING)
    },
    getError(keys: string[]) {
      return keys?.find?.(s => this._error.get(s)) ?? null
    },
  },
})

//* --- Utils ----------------------------------------------- *//

export interface IRequestMetaWrapperPayload<T> {
  key: string
  attemptCounts?: number
  callback: (payload: ICallback) => T extends boolean ? void : T
  successCallback?: (payload: SuccessCallback<T>) => Promise<void> | void | unknown
  errorCallback?: (payload: ErrorCallback) => Promise<void> | void | unknown
}

type RequestMetaError = null | unknown | string
interface ICallback {
  state: IRequestMetaState
}
type SuccessCallback<T> = ICallback & { data: Awaited<T> }
type ErrorCallback = ICallback & { errors: Error | AxiosError }

interface IRetryResult<T> {
  result?: Awaited<T> | null
  errors: Error | AxiosError | null
}

export type RequestMetaStore = ReturnType<typeof useRequestMeta>
