<script>
export default {
  name: 'register',
  data() {
      return {
        email: '',
        plainPassword: '',
        password_confirmation: '',
        error: ''
      }
  },
  computed: {
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    }
  },
  created() {
    if (this.loggedIn) {
      this.$router.push('/home');
    }
  },

  methods: {
    handleRegister(user) {
      console.log(user);
      if (user.plainPassword !== user.password_confirmation) {
        this.error = 'Les mots de passe ne correspondent pas';
        return;
      }
      this.$store.dispatch('auth/register', user)
        .then(() => {
          this.$router.push('/login');
        })
        .catch((error) => {
          this.error = error;
        });
    }
  }
}
</script>

<template>
  <div class="flex justify-center items-center h-screen">
    <div class="w-2/3 h-4/6 rounded-3xl shadow-md bg-white/30 flex">
      <div class="w-1/3 flex flex-col justify-center items-center px-2">
        <FormKit
            type="form"
            form-class="w-full flex justify-center  flex-col h-4/6"
            @submit="handleRegister"
            submit-label="Créer mon compte"
        >
          <FormKit
              type="text"
              name="email"
              label="Email"
              placeholder="exemple@email.here"
              validation="required|email"
              v-model="email"
          />
          <FormKit
              type="password"
              name="plainPassword"
              label="Password"
              placeholder="Mot de passe"
              validation="required|password"
              v-model="plainPassword"
          />
          <FormKit
              type="password"
              name="password_confirmation"
              label="Password Confirmation"
              placeholder="Mot de passe"
              validation="required|password"
              v-model="password_confirmation"
          />
        </FormKit>
        <div class="h-1/6 w-full mt-10" />
      </div>
    </div>
  </div>
</template>