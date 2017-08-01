import AuthAction from '../Auth/Actions'
import * as type from './Types'

/**
 * Actions
 */
const actions = {
  /**
   * Messages Alert & Notification
   * @param commit
   * @param payload
   */
  setMessage({commit}, payload) {
    payload.msg.forEach(function (msg) {
      // Set Unique
      msg = msg + '{|?' + Math.random()

      // Commit Mutations
      commit(type.SET_MESSAGE, {'type': payload.type, 'msg': msg})

      // Add Timer
      setTimeout(function () {
        commit(type.DELETE_NOTIFICATION, {'type': payload.type, 'msg': msg})
      }, CONST_NOTIFY_DURATION)
    })
  },
  deleteMessage({commit}, payload) {
    commit(type.DELETE_MESSAGE, payload)
  },
  deleteNotification({commit}, payload) {
    commit(type.DELETE_NOTIFICATION, payload)
  },
  resetMessages({commit}) {
    commit(type.RESET_MESSAGE)
  },

  /**
   * Progress Bar
   * @param commit
   */
  startLoading({commit}) {
    commit(type.SET_LOADING, true)
  },
  stopLoading({commit}) {
    commit(type.SET_LOADING, false)
  },

  /**
   * Head Editor
   */
  setHead({commit, state}, payload){
    let appendStore = []
    let clearElements = state.head.dynamic.slice()

    /**
     * Change Title
     * @param data
     */
    function setTitle(data) {
      if (!data) return
      let text = data.text ? data.text : state.head.defaults.title.text
      window.document.title = data.pattern ? data.pattern.replace('%T', text) : state.head.defaults.title.pattern.replace('%T', text)
    }

    /**
     * Clear Append Element
     */
    function clearElement() {
      if (!clearElements.length) return
      clearElements.map(el => {
        el.parentElement.removeChild(el)
      })
    }

    /**
     * Create Html Element
     * @param data
     * @param el
     * @returns {*}
     */
    function prepareElement(data, el) {
      Object.keys(data).map(prop => {
        if (prop === 'inner') {
          el.textContent = data[prop]
          return
        }
        el.setAttribute(prop, data[prop])
      })
      return el
    }

    /**
     * Append Head Element
     * @param type
     * @param data
     */
    function setElement(type, data) {
      if (!data) return
      let head = window.document.getElementsByTagName('head')[0]
      //let elements = state.head.dynamic

      data.map(function (obj) {
        let newElement = window.document.createElement(type)
        let htmlElement = prepareElement(obj, newElement)

        // Diff Element
        let equal = clearElements.filter(function (elem, index) {
          let r = htmlElement.isEqualNode(elem)
          if (r) clearElements.splice(index, 1)
          return r
        })

        // Append Element
        if (equal.length == 0) {
          head.appendChild(htmlElement)
        }

        // Store
        appendStore.push(htmlElement)
      })

      clearElement()
    }

    Object.keys(payload).map(function (type) {
      if (type === 'title') {
        setTitle(payload[type])
      } else {
        setElement(type, payload[type])
      }
    })

    commit(type.SET_HEAD, appendStore)
  },
  setHeadDefault({commit}, payload){
    commit(type.SET_HEAD_DEFAULT, payload)
  }
}

/**
 * Extract Auth Actions
 */
for (var key in AuthAction) {
  actions[key] = AuthAction[key]
}

export default actions