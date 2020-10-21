const state = {
  params: null,
  page: null
}

const mutations = {
  SET_PARAMS: (state, value) => {
    state.params = value
  },

  SET_PAGE: (state, value) => {
    state.page = value
  }
}

const actions = {
  init ({ commit }, data) {
    data.page = data.page ? data.page : ''
    if (!data.params) {
      switch (data.page) {
        case 'index':
          data.params = [
            {
              id: 1,
              type: 'navigation',
              default: true,
              data: {
                app_name: '应用名称',
                app_skin: '#ffffff',
                navigation_bar_text_style: '#000000'
              }
            }, {
              id: 2,
              type: 'tabbar',
              default: true,
              data: {
                background: '#ffffff',
                color: '#646566',
                color_active: '#353535',
                item: [
                  {
                    text: '名称',
                    link: '',
                    image: '',
                    image_active: ''
                  }, {
                    text: '名称',
                    link: '',
                    image: '',
                    image_active: ''
                  }, {
                    text: '名称',
                    link: '',
                    image: '',
                    image_active: ''
                  }, {
                    text: '名称',
                    link: '',
                    image: '',
                    image_active: ''
                  }
                ]
              }
            }
          ]
          break

        case 'category':
          data.params = [
            {
              id: 1,
              type: 'navigation',
              default: true,
              disabled: true,
              data: {
                app_name: '应用名称',
                app_skin: '#ffffff',
                navigation_bar_text_style: '#000000'
              }
            }, {
              id: 2,
              type: 'category',
              default: true,
              data: {
                layout: 10
              }
            }
          ]
          break

        case 'cart':
          data.params = [
            {
              id: 1,
              type: 'navigation',
              default: true,
              disabled: true,
              data: {
                app_name: '应用名称',
                app_skin: '#ffffff',
                navigation_bar_text_style: '#000000'
              }
            }, {
              id: 2,
              type: 'fixd',
              default: true,
              disabled: true,
              data: {}
            }
          ]
          break

        case 'mine':
          data.params = [
            {
              id: 1,
              type: 'navigation',
              default: true, // 不能拖拽
              disabled: true, // 不能点击
              data: {
                app_name: '应用名称',
                app_skin: '#ffffff',
                navigation_bar_text_style: 'black'
              }
            }, {
              id: 2,
              type: 'mine',
              default: true,
              data: {
                background_image: '',
                color: '#353535'
              }
            }
          ]
          break
      }
    }
    commit('SET_PARAMS', data.params)
    commit('SET_PAGE', data.page)
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}

