<template>
  <div
    class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg"
  v-cloak>
    <div class="flex-auto p-4">
      <div class="flex flex-wrap">
        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
          <h5 class="text-blueGray-400 uppercase font-bold text-xs">
            {{ statSubtitle }}
          </h5>
          <span class="font-semibold text-xl text-blueGray-700">
            {{ statTitle }}
          </span>
        </div>
        <div class="relative w-auto pl-4 flex-initial">
          <div
            class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full"
            :class="[statIconColor]"
          >
            <span class="material-icons">{{ statIconName }}</span>
          </div>
        </div>
      </div>
      <p class="text-sm text-blueGray-500 mt-4">
        <span v-if="statArrow" class="mr-2" :class="[statPercentColor]">
          <i
            :class="[
              statArrow === 'up' ? `fas fa-arrow-up` : `fas fa-arrow-down`,
            ]"
          ></i>
          {{ statPercent }}%
        </span>
        <span class="whitespace-nowrap">{{ statDescripiron }}</span>
      </p>
    </div>
  </div>
</template>
<script>
export default {
  name: "card-stats",
  props: {
    statSubtitle: {
      type: String,

    },
    statTitle: {
      type: Number,

    },
    statArrow: {

      validator: function (value) {
        // The value must match one of these strings
        return ["up", "down"].indexOf(value) !== -1;
      },
    },
    statPercent: {
      type: String,

    },
    // can be any of the text color utilities
    // from tailwindcss
    statPercentColor: {
      type: String,

    },
    statDescripiron: {
      type: String,

    },
    statIconName: {
      type: String,

    },
    // can be any of the background color utilities
    // from tailwindcss
    statIconColor: {
      type: String,

    },
  },
};
</script>
