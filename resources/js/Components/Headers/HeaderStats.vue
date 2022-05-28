<template>
  <!-- Header -->
  <div class="relative bg-emerald-600 md:pt-32 pb-32 pt-12">
    <div class="px-4 md:px-10 mx-auto w-full">
      <div>
        <!-- Card stats -->
        <transition-group appear @enter="enter" tag="div" class="flex flex-wrap">
          <div class="w-full lg:w-6/12 xl:w-3/12 px-4" data-index="1" key="1">
            <card-stats
              statSubtitle="CATEGORIES"
              :statTitle="$page.props.auth.user.id"
              statIconName="view_list"
              statIconColor="bg-orange-500"
            />
          </div>
          <div class="w-full lg:w-6/12 xl:w-3/12 px-4" data-index="2" key="2">
            <card-stats
              statSubtitle="PRODUCTS"
              :statTitle="$page.props.auth.user.id"
              statIconName="lunch_dining"
              statIconColor="bg-pink-500"
            />
          </div>
        </transition-group>
      </div>
    </div>
  </div>
</template>

<script setup>
import CardStats from "@/Components/Cards/CardStats.vue";
import gsap from "gsap";

const enter = (el) => {
  gsap.from(el, {
    opacity: 0,
    duration: 0.4,
    scale: 0.8,
    y: '10px',
    delay: el.dataset.index * 0.2

  })
}

</script>
