<template>
  <table>
    <thead>
      <tr>
        <th v-for="(header, index) in headers"
            :key="`header-${index}`"
            :class="header.class || 'text-left'">{{ header.name }}</th>
      </tr>
    </thead>
    <tbody>
      <slot></slot>
    </tbody>
  </table>
</template>

<script>
export default {
  props: {
    headers: {
      type: Array,
      required: true,
    },
  },

  data() {
    return {};
  },

  computed: {},

  methods: {},

  watch: {},

  mounted() {},
};
</script>