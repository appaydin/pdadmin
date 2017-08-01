<template>
    <div class="content register-page">
        <div class="header">
            <h3>REGISTER</h3>
            <div class="float-icon">
                <ui-fab color="accent" icon="security" @click="go('auth.login')" tooltip="Login" tooltip-position="left middle"></ui-fab>
                <ui-fab color="primary" icon="email" @click="go('auth.forgot')" tooltip="Forgotten Password" tooltip-position="left middle"></ui-fab>
            </div>
        </div>

        <ui-textbox floating-label label="Username / Email" v-model="msg"></ui-textbox>
        <ui-textbox floating-label label="Password" v-model="msg"></ui-textbox>

        <div class="submit">
            <ui-button :loading="this.$store.state.loading" size="large" color="primary" raised>REGISTER</ui-button>
        </div>
    </div>
</template>
<script>
    export default{
        data() {
            return{
                msg:'hello vue'
            }
        },
        methods:{
            go(name) {
                this.$router.push({ 'name': name })
            }
        },
        created(){
            this.$store.dispatch('setHead', {
                title: {
                    text: 'Register'
                },
                meta: [
                    {name:"test", content:"testx"},
                    {name:"test2", content:"testx"},
                    {name:"test22", content:"testx"},
                    {name:"test222", content:"testx"}
                ]
            })
        }
    }
</script>
