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

      axios.post('/createDealAndAccount', {
        deal_name: dealName.value,
        deal_stage: dealStage.value,
        account_name: accountName.value,
        account_website: accountWebsite.value,
        account_phone: accountPhone.value
      })
        .then(response => {
          console.log(response.data);
          Swal.fire(
            `${response.data.message}`,
            'success'
          );
          // Display success message
        })
        .catch(error => {
          console.error(error);
          // Display error message
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
<!-- <template>
  <div>
    <form @submit.prevent="submitForm">
      <div>
        <label for="deal-name">Deal Name:</label>
        <input type="text" id="deal-name" v-model="dealName" required>
      </div>
      <div>
        <label for="deal-stage">Deal Stage:</label>
        <input type="text" id="deal-stage" v-model="dealStage" required>
      </div>
      <div>
        <label for="account-name">Account Name:</label>
        <input type="text" id="account-name" v-model="accountName" required>
      </div>
      <div>
        <label for="account-website">Account Website:</label>
        <input type="text" id="account-website" v-model="accountWebsite" required>
      </div>
      <div>
        <label for="account-phone">Account Phone:</label>
        <input type="text" id="account-phone" v-model="accountPhone" required>
      </div>
      <div>
        <button type="submit">Create</button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      dealName: '',
      dealStage: '',
      accountName: '',
      accountWebsite: '',
      accountPhone: '',
    };
  },
  methods: {
    submitForm() {
      const data = {
        deal_name: this.dealName,
        stage: this.dealStage,
        account_name: this.accountName,
        website: this.accountWebsite,
        phone: this.accountPhone,
      };

      axios.post('/createDealAndAccount', data)
        .then(response => {
          console.log(response.data);
          // Display success message
        })
        .catch(error => {
          console.error(error);
          // Display error message
        });
    },
  },
};
</script> -->
