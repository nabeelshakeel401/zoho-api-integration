<template>
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
</script>
