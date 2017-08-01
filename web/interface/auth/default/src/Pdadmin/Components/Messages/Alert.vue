<template>
    <div class="alerts-container">
        <slot name="info" v-if="hasInfoMessage" v-for="msg in messages.info" :msg="msg">
            <ui-alert @dismiss="dismiss('info', msg)">{{ removeUniqueID(msg) }}</ui-alert>
        </slot>

        <slot name="success" v-if="hasSuccessMessage" v-for="msg in messages.success" :msg="msg">
            <ui-alert @dismiss="dismiss('success', msg)" type="success">{{ removeUniqueID(msg) }}</ui-alert>
        </slot>

        <slot name="warning" v-if="hasSuccessMessage" v-for="msg in messages.warning" :msg="msg">
            <ui-alert @dismiss="dismiss('warning', msg)" type="warning">{{ removeUniqueID(msg) }}</ui-alert>
        </slot>

        <slot name="error" v-if="hasErrorMessages" v-for="msg in messages.error" :msg="msg">
            <ui-alert @dismiss="dismiss('error', msg)" type="error">{{ removeUniqueID(msg) }}</ui-alert>
        </slot>

        <slot name="validation" v-if="hasValidationMessage" v-for="msg in messages.validation" :msg="msg">
            <ui-alert @dismiss="dismiss('validation', msg)" type="error">{{ removeUniqueID(msg) }}</ui-alert>
        </slot>
    </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'

  export default {
   props: ['info', 'success', 'warning', 'error', 'validation'],

    computed: {
      ...mapState(['messages']),

      hasInfoMessage() {
        return (this.messages.info.length > 0) && this.info
      },
      hasSuccessMessage() {
        return (this.messages.success.length > 0) && this.success
      },
      hasWarningMessages() {
        return (this.messages.warning.length > 0) && this.warning
      },
      hasErrorMessages() {
        return (this.messages.error.length > 0) && this.error
      },
      hasValidationMessage() {
        return (this.messages.validation.length > 0) && this.validation
      }
    },

    methods: {
      ...mapActions(['deleteMessage']),
      dismiss(type, msg) {
        this.deleteMessage({ 'type': type, 'msg': msg })
      },
      removeUniqueID(msg) {
        return msg.split('{|?', 1)[0]
      }
    }
  }
</script>
