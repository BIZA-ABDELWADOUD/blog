

<template>
  <div>
    <!-- container fluid -->
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3 class="m-0">Roles Assignement</h3>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active">Roles Page</li>
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
            <Select
              style="width: 25%; margin: 10px 0"
              v-model="data.id"
              placeholder="Select User Type"
              @on-change="refresh"
            >
              <Option
                :value="role.id"
                v-for="(role, i) in roles"
                :key="i"
                v-if="roles.length"
                >{{ role.roleName }}</Option
              >
            </Select>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>Resource Name</th>
                  <th>Read</th>
                  <th>Write</th>
                  <th>Update</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(re,i) in resources" :key="i">
                  <td>{{re.resourceName}}</td>
                  <td> <i-switch size="small" v-model="re.read" true-color="#13ce66" false-color="#ff4949" /></td>
                  <td> <i-switch size="small" v-model="re.write" true-color="#13ce66" false-color="#ff4949" /></td>
                  <td> <i-switch size="small" v-model="re.update" true-color="#13ce66" false-color="#ff4949" /></td>
                  <td> <i-switch size="small" v-model="re.delete" true-color="#13ce66" false-color="#ff4949" /></td>

                </tr>
               
              </tbody>
               <div class="assign_button">
                    <Button type="primary" :loading="isAffecting" :disabled="isAffecting" @click="AssignRoles">Affect</Button>
                </div>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
export default {
  data() {
    return {
      data: {
        roleName: "",
        id: null,
      },
      isAffecting : false,
      roles: [],
      resources: [
        {
          resourceName: "Dashboard",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "/",
        },
        {

          resourceName: "Tags",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "tags",
        },
        {
          resourceName: "Categories",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "categories",
        },
        {
          resourceName: "Blogs",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "blogs",
        },
         {
          resourceName: "List Of Blogs",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "blogsList",
        },
        {
          resourceName: "Users",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "users",
        },
        {
          resourceName: "Roles Management",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "role",
        },
         
         {
          resourceName: "Roles Assignement",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "Assign_Roles",
        },
        
      ],
        DefaultRessources: [
           {
          resourceName: "Dashboard",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "/",
        },
        {
          resourceName: "Tags",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "tags",
        },
        {
          resourceName: "Categories",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "categories",
        },
          {
          resourceName: "Blogs",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "blogs",
        },
         {
          resourceName: "List Of Blogs",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "blogsList",
        },
        {
          resourceName: "Users",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "users",
        },
        {
          resourceName: "Roles Management",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "role",
        },
        
         {
          resourceName: "Roles Assignement",
          read: false,
          write: false,
          update: false,
          delete: false,
          name: "Assign_Roles",
        },
        
      ],
    };
  },

  methods: {
    async AssignRoles() {
      let alldata = JSON.stringify(this.resources)
      const res = await this.ExecuteMethod('post','app/assign_roles',{'Permission' : alldata, id : this.data.id})
      if(res.status == 200) {
        this.message("success","Roles have been affected succefully")
        let index = this.roles.findIndex(role => role.id == this.data.id)
        this.roles[index].Permission = alldata

      }else {
        this.swr()
      }
    },

    refresh() {
      let index = this.roles.findIndex(role => role.id == this.data.id)
      let Permission = this.roles[index].Permission
      if(!Permission) {
          this.resources = this.DefaultRessources
      }
      else {
        this.resources = JSON.parse(Permission)
      }
    }
  },

  async created() {
    const res = await this.ExecuteMethod("get", "/app/get_roles");
    if (res.status == 200) {
      this.roles = res.data;
      if(res.data.length) {
         this.data.id = res.data[0].id
         if(res.data[0].Permission) {
           this.resources = JSON.parse(res.data[0].Permission)
          //this.resources = this.DefaultRessources
         }

      }
    } else {
      this.swr();
    }
  },
};
</script>