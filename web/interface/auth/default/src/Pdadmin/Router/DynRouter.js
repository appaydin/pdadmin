export default {
  name: 'DynamicRouter',
  template: '<div v-if="error404">{{ error404 }}</div>',

  data() {
    return {
      dynComponent: '',
      error404    : false
    }
  },

  methods: {
    /**
     * Create Dynamic Component
     * @param response
     */
    createComponent(response) {
      // Parse Data
      let view = JSON.parse(response.view)
      let comp = view.script ? eval(view.script)[0] : {}

      // Component Add Template
      comp.template = view.template ? view.template : '<div></div>'

      // Component Add Data
      if (response.data) {
        let data = comp.data ? comp.data() : {};
        comp.data = function () {
          data.data = response.data
          return data
        }
      }

      // Component Activate
      let uniqueID = 'comp' + Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
      this.$options.components[uniqueID] = comp;
      this.dynComponent = uniqueID
    },

    /**
     * Get URL Content
     * @param url
     */
    getUrl(url) {
      return this.$http.get(url).then((response) => {
        if (response.data.view) {
          this.createComponent(response.data)
        }
      }).catch((error) => {
        const { response } = error

        // 404 Error
        if (response.status == 404) {
          this.error404 = response.data.messages.error ? response.data.messages.error[0] : '404: Not Found!'
        }
      })
    }
  },

  /**
   * Watch URL Changes
   * Get Route Content
   */
  watch: {
    '$route' (to) {
      this.getUrl(to.fullPath)
    }
  },

  /**
   * Load First Route Content
   */
  created() {
    this.getUrl(this.$route.fullPath)
  }
}