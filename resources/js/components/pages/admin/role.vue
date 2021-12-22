

<template>
  <div>
    <!-- container fluid -->
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3 class="m-0">Roles Page</h3>
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
            <Button size="small" type="primary" @click="Addmodal = true"
              ><Icon type="md-add" />
              Add Role
            </Button>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Role Name</th>
                  <th>Creation</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(role,i) in roles" :key="i" v-if="roles.length">
                  <td>{{i+1}}</td>
                  <td>{{role.roleName}}</td>
                  <td>{{ moment(role.created_at).fromNow() }}</td>
                  <td>
                    <Button size="small" type="warning" @click="showeditmodal(role,i)">Edit</Button>
                    <Button size="small" type="error" @click="showdeletingmodal(role,i)" :loading="role.isDeleting">Delete</Button>
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
    <Modal
      v-model="Addmodal"
      title="Add Role"
    
    >
      <Input
        v-model="data.roleName"
        placeholder="Role Name"
        style="width: 100%"
      />
      <div slot="footer">
        <Button size="small" @click="Addmodal = false">Close</Button>
        <Button type="success" size="small" @click="addRole" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Role'}}</Button>
      </div>
    </Modal>
    <!-- end modal to add a new tag -->

        <!-- modal to edit tag -->
    <Modal
      v-model="Editmodal"
      title="Edit Role"

    >
      <Input
        v-model="editdata.roleName"
        placeholder="Role Name"
        style="width: 100%"
      />
      <div slot="footer">
        <Button size="small" @click="Editmodal = false">Close</Button>
        <Button type="success" size="small" @click="editRole" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Role'}}</Button>
      </div>
    </Modal>
    <!-- end modal to edit tag -->

    <!-- modal to delete tag -->
     <Modal v-model="deletemodal" width="360">
        <p slot="header" style="color:#f60;text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span> confirmation</span>
        </p>
        <div style="text-align:center">
          <p>Are you sure to delete the tag : <span style="color:#ed4014">{{deleteitem.tagName}}</span> ?</p>
        </div>
        <div slot="footer">
            <Button type="error" size="large" long :disabled="isDeleting" :loading="isDeleting" @click="deleteTag">{{isDeleting ? 'Deleting...' : 'Delete'}}</Button>
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
        roleName: "",
      },
      Addmodal: false,
      isAdding: false,
      roles: [],
      Editmodal:false,
       editdata: {
        roleName: "",
      },
      index : -1,
      deletemodal : false,
      deleteitem : {},
      deletingIndex : -1,
      isAdding : false,
      isDeleting :false
    };
  },

  methods: {
    // methos to add new tag
    async addRole() {
       if (this.data.roleName.trim() == "")
         return this.message("error", "Role Name can not be empty");
         this.isAdding = true
      const res = await this.ExecuteMethod(
        "post",
        "/app/create_role",
        this.data
      );
      if (res.status == 201) {
        ;
        this.isAdding = false
        this.roles.unshift(res.data)
        this.message("success", "Role was added successfully.")
        this.Addmodal = false;
        this.data.roleName = "";
      } 
      if(res.status= 422) {
        this.isAdding = false
        if(res.data.errors.roleName) {
          this.message('error',res.data.errors.roleName[0])
        }
    }
      else {
        this.isAdding = false
        this.swr();
      }
    },
    // end method to add new tag
    // method to modify tag
      async editRole() {
       if (this.editdata.roleName.trim() == "")
      return this.message("error", "Role Name can not be empty");
      this.isAdding = true
      const res = await this.ExecuteMethod(
        "post",
        "/app/edit_role",
        this.editdata
      );
      if (res.status == 200) {
        ;
        this.isAdding = false
        this.roles[this.index].roleName = this.editdata.roleName
        this.message("success", "Role Name was edited successfully.")
        this.Editmodal = false;

      } 
      if(res.status= 422) {
        this.isAdding = false
        if(res.data.errors.roleName) {
          this.message('error',res.data.errors.roleName[0])
        }
    }
      else {
        this.isAdding = false
        this.swr();
      }
    },
    // end method to modify tag
    showeditmodal(role,index) {
      let obj = {
        id : role.id,
        roleName : role.roleName
      }
      this.editdata = obj
      this.Editmodal = true
      this.index = index
    },
    async deleteTag(tag,i) {
      this.isDeleting = true
      const res = await this.ExecuteMethod('post','/app/delete_tag',this.deleteitem)
      if(res.status==200) {
        this.tags.splice(this.deletingIndex,1)
        this.message("success", "Tag Name was deleted successfully.")
      }
      else {
        this.swr();
      }
       this.isDeleting = false
       this.deletemodal = false
    },
    showdeletingmodal(tag,i) {
      this.deleteitem = tag
      this.deletingIndex = i
      this.deletemodal = true
    }
  },

  async created() {
    const res = await this.ExecuteMethod("get", "/app/get_roles");
    if (res.status == 200) {
      this.roles = res.data 
    } 
    
    else {
      this.swr()
    }
  },
};
</script>