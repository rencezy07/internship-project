<script setup>
import updateInfo from './Sections/UpdateInfo.vue';

defineProps({
  user: Object  
})
</script>


<template>
    <Head title="Profile"/>
    <updateInfo :user="user"/>
</template>