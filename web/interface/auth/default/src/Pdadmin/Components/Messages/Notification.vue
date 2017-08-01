<template>
    <div class="notification-container">
        <slot name="info" v-if="hasInfoMessage" v-for="msg in notification.info" :msg="msg">
            <ui-alert @dismiss="dismiss('info', msg)">{{ removeUniqueID(msg) }}</ui-alert>
        </slot>

        <slot name="success" v-if="hasSuccessMessage" v-for="msg in notification.success" :msg="msg">
            <ui-alert @dismiss="dismiss('success', msg)" type="success">{{ removeUniqueID(msg) }}</ui-alert>
        </slot>

        <slot name="warning" v-if="hasSuccessMessage" v-for="msg in notification.warning" :msg="msg">
            <ui-alert @dismiss="dismiss('warning', msg)" type="warning">{{ removeUniqueID(msg) }}</ui-alert>
        </slot>

        <slot name="error" v-if="hasErrorMessages" v-for="msg in notification.error" :msg="msg">
            <ui-alert @dismiss="dismiss('error', msg)" type="error">{{ removeUniqueID(msg) }}</ui-alert>
        </slot>

        <slot name="validation" v-if="hasValidationMessage" v-for="msg in notification.validation" :msg="msg">
            <ui-alert @dismiss="dismiss('validation', msg)" type="error">{{ removeUniqueID(msg) }}</ui-alert>
        </slot>
    </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'

  export default {
   props: ['info', 'success', 'warning', 'error', 'validation'],

    computed: {
      ...mapState(['notification']),

      hasInfoMessage() {
        return (this.notification.info.length > 0) && this.info
      },
      hasSuccessMessage() {
        return (this.notification.success.length > 0) && this.success
      },
      hasWarningMessages() {
        return (this.notification.warning.length > 0) && this.warning
      },
      hasErrorMessages() {
        return (this.notification.error.length > 0) && this.error
      },
      hasValidationMessage() {
        return (this.notification.validation.length > 0) && this.validation
      }
    },

    methods: {
      ...mapActions(['deleteNotification']),
      dismiss(type, msg) {
        this.deleteNotification({ 'type': type, 'msg': msg })
      },
      removeUniqueID(msg) {
        return msg.split('{|?', 1)[0]
      }
    }
  }

</script>

<style>
    .notification-container {
        position: fixed;
        z-index: 999;
        right: 20px;
        top: 20px;
        max-width: 500px;
        margin-left: 20px;
    }
    .ui-alert__content{
        word-break: break-all
    }
    .ui-alert__body{
        margin-left: auto;
        width: auto;
    }
</style>
