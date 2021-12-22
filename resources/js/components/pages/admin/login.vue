<template>
  <div>
    <div class="container-fluid ps-md-0">
      <div class="row g-0">
        <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
        <div class="col-md-8 col-lg-6">
          <div class="login d-flex align-items-center py-5">
            <div class="container">
              <div class="row">
                <div class="col-md-9 col-lg-8 mx-auto">
                  <h3 class="login-heading mb-4 text-center">Login</h3>

                  <!-- Sign In Form -->
                  <form>
                    <label>Email</label>
                    <Input
                      type="email"
                      v-model="data.email"
                      placeholder="Email"
                      style="width: 100%; margin: 10px 0"
                    />
                    <label>Password</label>
                    <Input
                      type="password"
                      v-model="data.password"
                      placeholder="Password"
                      style="width: 100%, margin: 10px 0"
                    />

                    <div class="form-check mb-3 mt-3">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        value=""
                        id="rememberPasswordCheck"
                      />
                      <label
                        class="form-check-label"
                        for="rememberPasswordCheck"
                      >
                        Remember password
                      </label>
                    </div>

                    <div class="d-grid">
                      <Button
                        type="primary"
                        @click="login"
                        :disabled="islogging"
                        :loading="islogging"
                        >{{ islogging ? "Login..." : "Login" }}</Button
                      >

                      <div class="text-center">
                        <a class="small" href="#">Forgot password?</a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {
        email: "",
        password: "",
      },
      islogging: false,
    };
  },
  methods: {
    async login() {
      if (this.data.email == "") return this.warning("please enter your email");
      if (this.data.password == "")
        return this.warning("please enter your password");
      this.islogging = true;
      const res = await this.ExecuteMethod(
        "post",
        "/app/user_login",
        this.data
      );
      if (res.status == 200) {
        // this.message("info", res.data.msg);
        window.location = '/'
      } else {
        if (res.status == 401) {
          this.error(res.data.msg);
        } else if (res.status == 422) {
          for (let i in res.data.errors) {
            this.error(res.data.errors[i][0]);
          }
        } else {
          this.swr();
        }
      }
      this.islogging = false;
    },
  },
};
</script>
