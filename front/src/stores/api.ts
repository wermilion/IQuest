import axios from 'axios';

const api = axios.create({
  baseURL: 'https://iquest-dev.tomsk-it.ru',
});

export const fetchData = async (path: string) => {
  try {
    const response = await api.get(path);
    return response.data;
  } catch (error) {
    throw new Error('Ошибка при получении данных с API');
  }
};
