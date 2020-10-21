export default {

  get: (key) => {
    try {
      return localStorage.getItem(key) || ''
    } catch (e) {
      console.error(e)
    }
  },

  set: (key, value) => {
    try {
      if (typeof value !== 'string') {
        value = JSON.stringify(value)
      }
      localStorage.setItem(key, value)
    } catch (e) {
      console.error(e)
    }
  },

  remove: (key) => {
    try {
      localStorage.removeItem(key)
    } catch (e) {
      console.error(e)
    }
  }
}
