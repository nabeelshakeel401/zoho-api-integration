<template>
  <v-sheet width="300" class="mx-auto">
    <v-form fast-fail @submit.prevent>
      <fieldset>
        <legend>Deal info:</legend>
        <v-text-field v-model="dealName" label="Deal Name" :rules="validation.dealName"></v-text-field>
        <v-text-field v-model="dealStage" label="Stage" :rules="validation.dealStage"></v-text-field>
      </fieldset>
      <fieldset>
        <legend>Account info:</legend>
        <v-text-field v-model="accountName" label="Account name" :rules="validation.accountName"></v-text-field>
        <v-text-field v-model="accountWebsite" label="Website" :rules="validation.accountWebsite"></v-text-field>
        <v-text-field v-model="accountPhone" label="Phone" :rules="validation.accountPhone"></v-text-field>
      </fieldset>
      <v-btn type="submit" @click="handleSubmit" block class="mt-2">Submit</v-btn>
    </v-form>
  </v-sheet>
</template>
<script>
import { ref } from 'vue';
import validation from "./validation";
import Swal from 'sweetalert2';
import axios from "axios";
export default {
  components: {
    validation
  },
  setup() {
    const dealName = ref('');
    const dealStage = ref('');
    const accountName = ref('');
    const accountWebsite = ref('');
    const accountPhone = ref('');
    const handleSubmit = () => {
        // let formValidated = true;

        let errorFields = document.querySelectorAll('form.v-form .v-field--error');
        console.log(errorFields);
        if (typeof errorFields != 'undefined' && errorFields.length > 0) {
            // formValidated = false;
            Swal.fire(
                'An error occurred!',
                `Please fix the highlighted errors!`,
                'error'
            );
            return;
        }

      axios.post('/createDealAndAccount', {
        deal_name: dealName.value,
        deal_stage: dealStage.value,
        account_name: accountName.value,
        account_website: accountWebsite.value,
        account_phone: accountPhone.value
      })
        .then(response => {
        //   console.log(response.data);
            Swal.fire(
                'Data Submitted!',
                `${response.data.message}`,
                'success'
            );
          // Display success message
        })
        .catch(error => {
            console.error(error);
            // Display error message
            Swal.fire(
                'An error occurred!',
                `${error.data.message}`,
                'error'
            );
        });

    };

    return {
      dealName,
      dealStage,
      accountName,
      accountWebsite,
      accountPhone,
      handleSubmit,
      validation: validation
    };
  },
};
</script>
<style>
fieldset {
  padding: 10px;
  margin: 0px 0px 15px 0px;
  border: 1px solid gray;
}
</style>
