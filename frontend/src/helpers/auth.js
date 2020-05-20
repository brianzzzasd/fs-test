import axios from 'axios';

export function login(credentials) {
  return new Promise((res, rej) => {
    axios.post('/auth/login', credentials)
      .then((response) => {
        res(response.data);
      })
      .catch((err) => {
        rej(err.data.message);
      })
  })
}

export function getLocalUser() {
  const user = localStorage.getItem('user');

  if (! user) {
    return null;
  }

  return JSON.parse(user);
}