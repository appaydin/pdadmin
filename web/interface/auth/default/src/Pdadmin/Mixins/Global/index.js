function install(Vue, options) {
  Vue.mixin({
    /**
     * Global Methods
     */
    methods: {
      go(name) {
        this.$router.push({'name': name})
      },
      goPath(path) {
        this.$router.push({'path': path})
      }
    }

  })
}

module.exports = install