<template>
  <v-card
    class="rounded-lg overflow-hidden"
    :class="customClass"
    flat
    :color="color"
    :outlined="outlined"
    :loading="loading"
  >
    <v-card-title v-if="title != ''"> {{ title }} </v-card-title>
    <v-card-subtitle v-if="subtitle != ''"> {{ subtitle }} </v-card-subtitle>
    <slot name="text"></slot>
    <slot name="actions"></slot>
  </v-card>
</template>
<script>
export default {
  props: {
    title: {
      type: String,
      required: false,
      default: "",
    },
    subtitle: {
      type: String,
      required: false,
      default: "",
    },
    color: {
      type: String,
      required: false,
      default: "",
    },
    outlined: {
      type: Boolean,
      default: false,
    },
    loading: {
      type: Boolean,
      default: false,
    },
    customClass: {
      type: String,
      default: "",
    },
  },
};
</script>