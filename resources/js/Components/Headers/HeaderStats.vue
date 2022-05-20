<template>
  <!-- Header -->
  <div class="relative bg-emerald-600 md:pt-32 pb-32 pt-12">
    <div class="px-4 md:px-10 mx-auto w-full">
      <div>
        <!-- Card stats -->
        <div class="flex flex-wrap">
          <!-- <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
            <card-stats
              statSubtitle="TRAFFIC"
              statTitle="350,897"
              statArrow="up"
              statPercent="3.48"
              statPercentColor="text-emerald-500"
              statDescripiron="Since last month"
              statIconName="far fa-chart-bar"
              statIconColor="bg-red-500"
            />
          </div> -->
          <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
            <card-stats
              statSubtitle="CATEGORIES"
              :statTitle="$page.props.auth.restorant.counts.categories_count"
              statIconName="view_list"
              statIconColor="bg-orange-500"
            />
          </div>
          <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
            <card-stats
              statSubtitle="PRODUCTS"
              :statTitle="$page.props.auth.restorant.counts.products_count"
              statIconName="lunch_dining"
              statIconColor="bg-pink-500"
            />
          </div>
          <!-- <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
            <card-stats
              statSubtitle="PERFORMANCE"
              statTitle="49,65%"
              statArrow="up"
              statPercent="12"
              statPercentColor="text-emerald-500"
              statDescripiron="Since last month"
              statIconName="fas fa-percent"
              statIconColor="bg-emerald-500"
            />
          </div> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import CardStats from "@/Components/Cards/CardStats.vue";


</script>
