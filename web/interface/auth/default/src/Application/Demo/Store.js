/**
 * Store State
 */
const state = {
  blogs: ''
}


/**
 * Store Mutations
 */
const mutations = {
  setBLog(state, data){
    state.blogs = data
  }
}


/**
 *  Store Actions
 */
const actions = {
  blogSetData({ commit }, data){
    commit('setBlog', data)
  }
}


/**
 * Store Plugins
 */
const plugins = (store) => {
  store.subscribe((mutation, { user }) => {
    if ('SET_TOKEN' === mutation.type) {
      // Plugin Code
    }
  })
}


/**
 * Vuex Module
 */
const module = {
  state,
  mutations,
  actions
}

export default { module, plugins }