<template>
    <div id="app">
        <progress-bar></progress-bar>
        <div class="container d-flex justify-content-center align-items-center">
            <div class="auth-form">
                <div class="logo"><img src="http://localhost/pdadmin/storage/logo.png"></div>
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  name: 'App'
}
</script>