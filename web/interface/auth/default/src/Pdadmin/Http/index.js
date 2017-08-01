/**
 * ============
 * Axios
 * ============
 *
 * Promise based HTTP client for the browser and node.js.
 *
 * https://github.com/mzabriskie/axios
 */
import Axios from 'axios';
import Interceptors from './Interceptors'

/**
 * Allow use http client without Vue instance
 * @type {AxiosInstance}
 */
export const Http = Axios.create({
  baseURL: CONST_API_URL,
  headers: { 'Content-Type': 'application/json' }
})

/**
 * Helper method to set the header with the token
 * @param token
 */
export function setAuthToken(token) {
  Http.defaults.headers.common.Authorization = 'Bearer ' + token
}

/**
 * Vue plugin
 * @param Vue
 * @param Store
 * @param Router
 * @returns {AxiosInstance}
 */
export default function install(Vue, { Store, Router }) {
  Interceptors(Http, Store, Router)
  Object.defineProperty(Vue.prototype, '$http', {
    get() {
      return Http
    },
  })
}