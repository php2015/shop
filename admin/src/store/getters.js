const getters = {
  // App
  sidebar: state => state.app.sidebar,
  device: state => state.app.device,
  size: state => state.app.size,
  // User
  token: state => state.user.token,
  username: state => state.user.username,
  realname: state => state.user.realname,
  avatar: state => state.user.avatar,
  menu: state => {
    return JSON.parse(state.user.menu)
  },
  // system
  system_name: state => state.system.name,
  copyright: state => state.system.name,
  logo: state => state.system.logo
}
export default getters
