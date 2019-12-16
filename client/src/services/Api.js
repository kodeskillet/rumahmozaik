import Axios from 'axios';

const api = Axios.create({
  baseURL: 'http://127.0.0.1:8000/api'
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
  product, catalog
}
