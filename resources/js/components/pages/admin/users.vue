<template>
  <div>
    <!-- container fluid -->
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Users Page</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active">Users Page</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <!-- Main content -->
    <div class="row mt-3">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <Button size="small" type="primary" @click="Addmodal = true"
              ><Icon type="md-add" />
              Add User
            </Button>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>User Type</th>
                  <th>Creation</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, i) in users" :key="i" v-if="users.length">
                  <td>{{ i + 1 }}</td>
                  <td>{{ user.FullName }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.role.roleName }}</td>
                  <td>{{ moment(user.created_at).fromNow() }}</td>
                  <td>
                    <Button
                      size="small"
                      type="warning"
                      @click="showeditmodal(user, i)"
                      >Edit</Button
                    >
                    <Button
                      size="small"
                      type="error"
                      @click="showdeletingmodal(user, i)"
                      :loading="user.isDeleting"
                      >Delete</Button
                    >
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.content -->

    <!-- modal to add a new tag -->
    <Modal v-model="Addmodal" title="Add User">
      <Input
        v-model="data.FullName"
        placeholder="Full Name"
        style="width: 100%; margin: 10px 0"
      />
      <Input
        v-model="data.email"
        placeholder="Email"
        style="width: 100%, margin: 10px 0"
      />
      <Input
        type="password"
        v-model="data.password"
        placeholder="Password"
        style="width: 100%; margin: 10px 0"
      />
      <Select
        v-model="data.role_id"
        style="width: 100%; margin: 10px 0"
        placeholder="Select User Type"
      >
        <Option :value="role.id" v-for="(role,i) in roles" :key="i" v-if="roles.length">{{role.roleName}}</Option>
      </Select>
      <div slot="footer">
        <Button size="small" @click="Addmodal = false">Close</Button>
        <Button
          type="success"
          size="small"
          @click="addUser"
          :disabled="isAdding"
          :loading="isAdding"
          >{{ isAdding ? "Adding..." : "Add User" }}</Button
        >
      </div>
    </Modal>
    <!-- end modal to add a new tag -->

    <!-- modal to edit tag -->
    <Modal v-model="Editmodal" title="Edit User">
      <Input
        v-model="editdata.FullName"
        placeholder="Full Name"
        style="width: 100%; margin: 10px 0"
      />
      <Input
        v-model="editdata.email"
        placeholder="Email"
        style="width: 100%, margin: 10px 0"
      />
     
      <Select
        v-model="editdata.role_id"
        style="width: 100%; margin: 10px 0"
        placeholder="Select User Type"
      >
      <Option :value="role.id" v-for="(role,i) in roles" :key="i" v-if="roles.length">{{role.roleName}}</Option>

      </Select>

      Reset Password (optional):
       <Input
        type="password"
        v-model="editdata.password"
        placeholder="Password"
        style="width: 100%; margin: 10px 0"
      />

      <div slot="footer">
        <Button size="small" @click="Editmodal = false">Close</Button>
        <Button
          type="success"
          size="small"
          @click="editUser"
          :disabled="isAdding"
          :loading="isAdding"
          >{{ isAdding ? "Editing..." : "Edit User" }}</Button
        >
      </div>
    </Modal>
    <!-- end modal to edit tag -->

    <!-- modal to delete tag -->
    <Modal v-model="deletemodal" width="360">
      <p slot="header" style="color: #f60; text-align: center">
        <Icon type="ios-information-circle"></Icon>
        <span> confirmation</span>
      </p>
      <div style="text-align: center">
        <p>
          Are you sure to delete the user :
          <span style="color: #ed4014">{{ deleteitem.FullName }}</span> ?
        </p>
      </div>
      <div slot="footer">
        <Button
          type="error"
          size="large"
          long
          :disabled="isDeleting"
          :loading="isDeleting"
          @click="deleteUser"
          >{{ isDeleting ? "Deleting..." : "Delete" }}</Button
        >
      </div>
    </Modal>
    <!-- end modal to delete tag -->
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
export default {
  data() {
    return {
      data: {
        FullName: "",
        email: "",
        password: "",
        role_id : null
      },
      editdata: {
        FullName: "",
        email: "",
        password: "",
        role_id: null,
        
      },
      Addmodal: false,
      isAdding: false,
      users: [],
      roles: [],
      Editmodal: false,
      updated : [],
      index: -1,
      deletemodal: false,
      deleteitem: {},
      deletingIndex: -1,
      isAdding: false,
      isDeleting: false,
    };
  },

  methods: {
    // methos to add new tag
    async addUser() {
      if (this.data.FullName.trim() == "")
        return this.message("error", "Name can not be empty");
      if (this.data.email.trim() == "")
        return this.message("error", "Email can not be empty");
      if (this.data.password.trim() == "")
        return this.message("error", "Password is required");
      if (!this.data.role_id)
        return this.message("error", "User Type can not be empty");
      this.isAdding = true;
      const res = await this.ExecuteMethod(
        "post",
        "/app/create_user",
        this.data
      );
      if (res.status == 201) {
        this.isAdding = false;
        this.users.unshift(res.data);
        this.message("success", "User was added successfully.");
        this.Addmodal = false;
      }
      if ((res.status = 422)) {
        this.isAdding = false;
        if (res.data.errors.FullName) {
          return this.message("error", res.data.errors.FullName[0]);
        }
        if (res.data.errors.email) {
          return this.message("error", res.data.errors.email[0]);
        }
        if (res.data.errors.password) {
          return this.message("error", res.data.errors.password[0]);
        }
        if (res.data.errors.userType) {
          return this.message("error", res.data.errors.userType[0]);
        }
      } else {
        this.isAdding = false;
        this.swr();
      }
    },
    // end method to add new tag
    // method to modify tag
    async editUser() {
      if (this.editdata.FullName.trim() == "")
        return this.message("error", "Name can not be empty");
      if (this.editdata.email.trim() == "")
        return this.message("error", "Email can not be empty");
      if (!this.editdata.role_id)
        return this.message("error", "User Type can not be empty");
      this.isAdding = true;
      const res = await this.ExecuteMethod(
        "post",
        "/app/edit_user",
        this.editdata
      );
      if (res.status == 200) {
         
        this.isAdding = false;
        this.updated = res.data;
        this.users[this.index].role.roleName = this.updated.role.roleName;
        this.users[this.index].FullName = this.editdata.FullName;
        this.users[this.index].email = this.editdata.email;
        this.users[this.index].password = this.editdata.password;
        this.users[this.index].userType = this.editdata.userType;
        this.message("success", "Tag specified user was edited successfully.");
        this.Editmodal = false;
      }
      if ((res.status = 422)) {
        this.isAdding = false;
        if (res.data.errors.tagName) {
          this.message("error", res.data.errors.tagName[0]);
        }
      } else {
        this.isAdding = false;
        this.swr();
      }
    },
    // end method to modify tag
    showeditmodal(user, index) {
      let obj = {
        id: user.id,
        FullName: user.FullName,
        email: user.email,
        role_id: user.role_id,
      };
      this.editdata = obj;
      this.Editmodal = true;
      this.index = index;
    },
    async deleteUser(user, i) {
      this.isDeleting = true;
      const res = await this.ExecuteMethod(
        "post",
        "/app/delete_user",
        this.deleteitem
      );
      if (res.status == 200) {
        this.users.splice(this.deletingIndex, 1);
        this.message("success", "The specified user was deleted successfully.");
      } else {
        this.swr();
      }
      this.isDeleting = false;
      this.deletemodal = false;
    },
    showdeletingmodal(user, i) {
      this.deleteitem = user;
      this.deletingIndex = i;
      this.deletemodal = true;
    },
  },

  async created() {
    const [res,resRoles] = await Promise.all([
       this.ExecuteMethod("get", "/app/get_users"),
      this.ExecuteMethod("get", "/app/get_roles")
    ])
    if (res.status == 200) {
      this.users = res.data;
    } else {
      this.swr();
    }
       if (resRoles.status == 200) {
      this.roles = resRoles.data;
    } else {
      this.swr();
    }
  },
};
</script>
