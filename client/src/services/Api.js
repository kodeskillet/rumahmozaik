import Axios from 'axios';

const baseUrl = `http://127.0.0.1:8000`

const api = Axios.create({
  baseURL: `${baseUrl}/api`
})

const product = {
  getAll () {
    return api.get('/product');
  }
}

const catalog = {
  getAll () {
    return api.get('/catalogtype')
  }
}

export default {
  baseUrl, product, catalog
}
