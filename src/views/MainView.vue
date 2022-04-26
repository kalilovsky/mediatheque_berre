<template>
  <ConfirmDialog></ConfirmDialog>
  <slot></slot>
</template>

<script>
import ConfirmDialog from 'primevue/confirmdialog';
export default {
  components:{
    ConfirmDialog,
  }
}
</script>

<style>

</style>