<script>
    export default {
        created() {
            this.$store.dispatch('attemptLogout')
                .then(() => {
                    this.$router.push({
                        name: 'auth.login'
                    })
                })
        }
    }
</script>
