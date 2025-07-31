import { createToast } from 'mosha-vue-toastify';
import 'mosha-vue-toastify/dist/style.css'

export function makeToast(text, type = 'success', timeout = 10000) {
  createToast(text, {
    type: type,
    transition: 'slide',
    position: 'top-right',
    timeout: timeout,
  })
}