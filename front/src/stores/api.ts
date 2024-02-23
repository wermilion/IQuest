import axios from 'axios';

const api = axios.create({
  baseURL: 'https://iquest-dev.tomsk-it.ru', // Базовый URL уже определен здесь
});

export const fetchData = async (path: string, body?: any) => {
  try {
    const response = body ? await api.post(path, body) : await api.get(path);
    return response.data;
  } catch (error) {
    throw new Error('Ошибка при получении данных с API');
  }
};
