

<template>
  <div>
    <!-- container fluid -->
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3 class="m-0">Tags Page</h3>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active">Tags Page</li>
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
              v-if="isWritePermitted"><Icon type="md-add" />
              Add Tag
            </Button>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tag Name</th>
                  <th>Creation</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(tag,i) in tags" :key="i" v-if="tags.length">
                  <td>{{i+1}}</td>
                  <td>{{tag.tagName}}</td>
                  <td>{{ moment(tag.created_at).fromNow() }}</td>
                  <td>
                    <Button size="small" type="warning" @click="showeditmodal(tag,i)" v-if="isUpdatePermitted">Edit</Button>
                    <Button size="small" type="error" @click="showdeletingmodal(tag,i)" v-if="isDeletePermitted" :loading="tag.isDeleting">Delete</Button>
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
      title="Add Tag"
    
    >
      <Input
        v-model="data.tagName"
        placeholder="Tag Name"
        style="width: 100%"
      />
      <div slot="footer">
        <Button size="small" @click="Addmodal = false">Close</Button>
        <Button type="success" size="small" @click="addTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Tag'}}</Button>
      </div>
    </Modal>
    <!-- end modal to add a new tag -->

        <!-- modal to edit tag -->
    <Modal
      v-model="Editmodal"
      title="Edit Tag"

    >
      <Input
        v-model="editdata.tagName"
        placeholder="Tag Name"
        style="width: 100%"
      />
      <div slot="footer">
        <Button size="small" @click="Editmodal = false">Close</Button>
        <Button type="success" size="small" @click="editTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Tag'}}</Button>
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
        tagName: "",
      },
      Addmodal: false,
      isAdding: false,
      tags: [],
      Editmodal:false,
       editdata: {
        tagName: "",
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
    async addTag() {
       if (this.data.tagName.trim() == "")
         return this.message("error", "Tag Name can not be empty");
         this.isAdding = true
      const res = await this.ExecuteMethod(
        "post",
        "/app/create_tag",
        this.data
      );
      if (res.status == 201) {
        ;
        this.isAdding = false
        this.tags.unshift(res.data)
        this.message("success", "Tag Name was added successfully.")
        this.Addmodal = false;
        this.data.tagName = "";
      } 
      if(res.status= 422) {
        this.isAdding = false
        if(res.data.errors.tagName) {
          this.message('error',res.data.errors.tagName[0])
        }
    }
      else {
        this.isAdding = false
        this.swr();
      }
    },
    // end method to add new tag
    // method to modify tag
      async editTag() {
       if (this.editdata.tagName.trim() == "")
      return this.message("error", "Tag Name can not be empty");
      this.isAdding = true
      const res = await this.ExecuteMethod(
        "post",
        "/app/edit_tag",
        this.editdata
      );
      if (res.status == 200) {
        ;
        this.isAdding = false
        this.tags[this.index].tagName = this.editdata.tagName
        this.message("success", "Tag Name was edited successfully.")
        this.Editmodal = false;

      } 
      if(res.status= 422) {
        this.isAdding = false
        if(res.data.errors.tagName) {
          this.message('error',res.data.errors.tagName[0])
        }
    }
      else {
        this.isAdding = false
        this.swr();
      }
    },
    // end method to modify tag
    showeditmodal(tag,index) {
      let obj = {
        id : tag.id,
        tagName : tag.tagName
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
    const res = await this.ExecuteMethod("get", "/app/get_tags");
    if (res.status == 200) {
      this.tags = res.data 
    } 
    
    else {
      this.swr()
    }
  },
};
</script>