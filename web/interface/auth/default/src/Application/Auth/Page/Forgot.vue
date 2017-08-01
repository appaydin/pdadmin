<template>
    <div class="content forgot-page">
        <alert info="true" error="true" success="true" validation="true" warning="true"></alert>

        <div class="header">
            <h3>FORGOT PASSWORD</h3>
            <div class="float-icon">
                <ui-fab color="accent" icon="add" @click="go('auth.register')" size="normal" tooltip="Register" tooltip-position="left middle"></ui-fab>
                <ui-fab color="primary" icon="email" @click="go('auth.forgot')" tooltip="Forgotten Password" tooltip-position="left middle"></ui-fab>
            </div>
        </div>

        <div class="input"><ui-textbox floating-label label="Username / Email" v-model="username"></ui-textbox></div>

        <div class="submit">
            <ui-button :loading="this.$store.state.loading" size="large" color="primary" raised @click="login()">SEND</ui-button>
        </div>
    </div>
</template>
<script>
    export default{
        data() {
            return {
                username:''
            }
        }
    }
</script>
