import axios from 'axios'

const baseDomain = process.env.VUE_APP_BASE_API_URL
const baseUri = ''
// const baseUri = process.env.VUE_APP_API_URI

export const baseURL = `${baseDomain}${baseUri}/`

export default axios.create({
    baseURL: baseURL,
})
