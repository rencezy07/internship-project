<script setup>
import Container from '../../../Components/User/Container.vue'
import Title from '../../../Components/User/Title.vue'
import InputField from '../../../Components/User/InputField.vue'
import PrimaryBtn from '../../../Components/User/PrimaryBtn.vue'
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: '',
    email: '',
})

</script>

<template>
    <Container class="mb-6">
    <div class="mb-6">
        <Title>Update Information</Title>
        <p>update your account</p>
    </div>

     <form class="space-y-6">
     
        <InputField
        label="Name"
        icon="user"
        class="w-1/2" v-model="form.name"/>  
        <InputField
        label="Email"
        icon="email"
        class="w-1/2"v-model="form.email"/>  

        <div><p>verify your email</p></div>
        <PrimaryBtn :disabled="form.processi">Save</PrimaryBtn>
     </form>
     
     </Container>
     
     
    
</template>