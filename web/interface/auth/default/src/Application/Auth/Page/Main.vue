<template>
    <transition
            name="custom-classes-transitions"
            enter-active-class="animated fadeInRight"
            leave-active-class="animated fadeOutLeft absolute">
        <router-view></router-view>
    </transition>
</template>
<script>
    export default {
        name: 'Auth'
    }
</script>
<style>
    .absolute{
        position: absolute !important;
        min-width: 300px
    }
</style>
