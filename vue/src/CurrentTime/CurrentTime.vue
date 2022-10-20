<!--
  Matomo - free/libre analytics platform

  @link https://matomo.org
  @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
-->

<template>
  <div class="current-time-component">
    <div class="clock" :title="timezone">
      <small v-if="currentTime && timezone != userTimezone">Website: </small>{{ currentTime }}
    </div>
    <div class="clock" :title="userTimezone" v-if="userTime && timezone != userTimezone">
      <small>You: </small>{{ userTime }}
    </div>
  </div>
</template>

<style lang="less" scoped>
    // @todo styles are not applying to this scope only for some reason
    .clock {
      font-size: 16px;
      text-align: center;
      padding-bottom: 20px;
    }
</style>

<script lang="ts">
import { defineComponent } from 'vue';

interface CurrentTimeState {
  currentTime: string;
  userTime: string;
  userTimezone: string;
  // @todo this should be private/non reactive
  interval?: number;
}

const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

// @todo need to check expected browser support for these date methods
export default defineComponent({
  props: {
    timezone: String,
  },
  data(): CurrentTimeState {
    return {
      currentTime: '',
      userTime: '',
      userTimezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
    };
  },
  mounted() {
    this.interval = setInterval(this.setTime.bind(this), 1000);
  },
  unmounted() {
    clearInterval(this.interval);
  },
  methods: {
    setTime() {
      this.currentTime = new Intl.DateTimeFormat(undefined, { dateStyle: 'short', timeStyle: 'medium', timeZone: this.timezone }).format(new Date());
      this.userTime = new Intl.DateTimeFormat(undefined, { dateStyle: 'short', timeStyle: 'medium', timeZone: userTimezone }).format(new Date());
    },
  },
});
</script>
