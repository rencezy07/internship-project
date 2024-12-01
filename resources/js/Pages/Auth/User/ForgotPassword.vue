<script setup>
import Container from '../../../Components/User/Container.vue'
import InputField from '../../../Components/User/InputField.vue'
import PrimaryBtn from '../../../Components/User/PrimaryBtn.vue'
import ErrorMessages from '../../../Components/User/ErrorMessages.vue'
import SessionMessages from '../../../Components/User/SessionMessages.vue'

import { useForm } from '@inertiajs/vue3'

const form = useForm({
    email:"",
  
});

defineProps({status: String})

const submit = () => {
    form.post(route("password.email"));
}

</script>


<template>
    <Head title="- Forgot Password"/>
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <p>Forgot your password? Ayg kabalaka.</p>
        </div>

        <!-- Error Messages -->
        <ErrorMessages :errors="form.errors"/>
        <SessionMessages :status="status"/>
        <form @submit.prevent="submit" class="space-y-7">
            <InputField label="Email" icon="envelope" v-model="form.email"/>
            <PrimaryBtn :disabled="form.processing">Reset Password</PrimaryBtn>
            
        </form>
    </Container>
</template>