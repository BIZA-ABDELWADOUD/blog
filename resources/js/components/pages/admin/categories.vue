<template>
  <div>
    <!-- container fluid -->
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3 class="m-0">Categories Page</h3>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active">Categories Page</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <!-- Main content -->
    <!-- Main content -->
    <div class="row mt-3">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <Button size="small" type="primary" @click="Addmodal = true"
              v-if="isWritePermitted"><Icon type="md-add" />
              Add Category
            </Button>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Category Name</th>
                  <th>Category Icon</th>
                  <th>Creation</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(category, i) in categories"
                  :key="i"
                  v-if="categories.length"
                >
                  <td>{{ i + 1 }}</td>
                  <td>{{ category.categoryName }}</td>
                  <td>
                    <img class="image_cat" :src="category.categoryIcon" />
                  </td>
                  <td>{{ moment(category.created_at).fromNow() }}</td>
                  <td>
                    <Button
                      size="small"
                      type="warning"
                      @click="showeditmodal(category, i)"
                      v-if="isUpdatePermitted">Edit</Button
                    >
                    <Button
                      size="small"
                      type="error"
                      @click="showdeletingmodal(category, i)"
                      :loading="category.isDeleting"
                      v-if="isDeletePermitted">Delete</Button
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

    <!-- modal to add a new category -->
    <Modal v-model="Addmodal" title="Add Category">
      <Input
        v-model="data.categoryName"
        placeholder="Category Name"
        style="width: 100%; margin: 10px 0"
      />
      <Upload
        ref="uploads"
        type="drag"
        :headers="{
          'x-csrf-token': token,
          'X-Requested-With': 'XMLHttpRequest',
        }"
        :on-success="handleSuccess"
        :on-error="handleError"
        :format="['jpg', 'jpeg', 'png']"
        :max-size="2048"
        :on-format-error="handleFormatError"
        :on-exceeded-size="handleMaxSize"
        action="/app/upload"
      >
        <div style="padding: 20px 0">
          <Icon type="ios-cloud-upload" size="52" style="color: #145896"></Icon>
          <p>Click or drag files here to upload</p>
        </div>
      </Upload>

      <div class="demo-upload-list" v-if="data.categoryIcon">
        <img :src="`/uploads/categories/${data.categoryIcon}`" />
        <div class="demo-upload-list-cover">
          <Icon type="ios-trash-outline" @click="deletIcon"></Icon>
        </div>
      </div>

      <div slot="footer">
        <Button size="small" @click="Addmodal = false">Close</Button>
        <Button
          type="success"
          size="small"
          @click="addCategory"
          :disabled="isAdding"
          :loading="isAdding"
          >{{ isAdding ? "Adding..." : "Add Category" }}</Button
        >
      </div>
    </Modal>
    <!-- end modal to add a new category -->

    <!-- modal to edit category -->
    <Modal v-model="Editmodal" title="Edit category" :closable="true" @on-cancel="closeEditmodal">
      <Input
        v-model="editdata.categoryName"
        placeholder="Category Name"
        style="width: 100%; margin: 20px 0"
      />
      <Upload
        v-show="isIconimagenew"
        ref="edituploads"
        type="drag"
        :headers="{
          'x-csrf-token': token,
          'X-Requested-With': 'XMLHttpRequest',
        }"
        :on-success="handleSuccess"
        :on-error="handleError"
        :format="['jpg', 'jpeg', 'png']"
        :max-size="2048"
        :on-format-error="handleFormatError"
        :on-exceeded-size="handleMaxSize"
        action="/app/upload/edit"
      >
        <div style="padding: 20px 0">
          <Icon type="ios-cloud-upload" size="52" style="color: #145896"></Icon>
          <p>Click or drag files here to upload</p>
        </div>
      </Upload>

      <div class="demo-upload-list" v-if="editdata.categoryIcon">
        <img :src="`${editdata.categoryIcon}`" />
        <div class="demo-upload-list-cover">
          <Icon type="ios-trash-outline" @click="deletIcon(false)"></Icon>
        </div>
      </div>
      <div slot="footer">
        <Button size="small" @click="closeEditmodal">Close</Button>
        <Button
          type="success"
          size="small"
          @click="editcategory"
          :disabled="isAdding"
          :loading="isAdding"
          >{{ isAdding ? "Editing..." : "Edit category" }}</Button
        >
      </div>
    </Modal>
    <!-- end modal to edit category -->

    <!-- modal to delete category -->
    <Modal v-model="deletemodal" width="360">
      <p slot="header" style="color: #f60; text-align: center">
        <Icon type="ios-information-circle"></Icon>
        <span> confirmation</span>
      </p>
      <div style="text-align: center">
        <p>
          Are you sure to delete the category :
          <span style="color: #ed4014">{{ deleteitem.categoryName }}</span> ?
        </p>
      </div>
      <div slot="footer">
        <Button
          type="error"
          size="large"
          long
          :disabled="isDeleting"
          :loading="isDeleting"
          @click="deletecategory"
          >{{ isDeleting ? "Deleting..." : "Delete" }}</Button
        >
      </div>
    </Modal>
    <!-- end modal to delete category -->
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
export default {
  data() {
    return {
      data: {
        categoryIcon: "",
        categoryName: "",
      },
      Addmodal: false,
      isAdding: false,
      categories: [],
      Editmodal: false,
      editdata: {
        categoryIcon: "",
        categoryName: "",
      },
      index: -1,
      deletemodal: false,
      deleteitem: {},
      deletingIndex: -1,
      isAdding: false,
      isDeleting: false,
      token: "",
      isIconimagenew: false,
      iseditingItem: false,
      standbyImage : false,
      recoveryimage : ''

    };
  },

  methods: {
   
    async deletIcon(isAdd = true) {
      if (!isAdd) {
        this.isIconimagenew = true
        this.recoveryimage = this.editdata.categoryIcon;
        this.standbyImage = true
        this.editdata.categoryIcon = "";
        this.$refs.edituploads.clearFiles();
      } else {
        let image = this.data.categoryIcon;
        this.data.categoryIcon = "";
        this.$refs.uploads.clearFiles();
        const res = await this.ExecuteMethod("post", "/app/delete_icon", {
          imageName: image,
        });

        if (res.status != 200) {
          this.data.categoryIcon = image;
          this.swr();
        }
      }
    },
    handleError(res, file) {
      this.message(
        "error",
        `${
          file.errors.file.length ? file.errors.file[0] : "Something went wrong"
        }`
      );
    },
    handleSuccess(res, file) {
      // res = `/uploads/categories/${res}`
      if (this.iseditingItem) {
        return (this.editdata.categoryIcon = res);
      }
      this.data.categoryIcon = res;
    },
    handleFormatError(file) {
      this.message(
        "error",
        file.name + " is incorrect, please select jpeg,jpg or png.."
      );
    },
    handleMaxSize(file) {
      this.message("error", file.name + "Exceeding file size limit.");
    },
    // methos to add new category
    async addCategory() {
      if (this.data.categoryName.trim() == "")
        return this.message("error", "Category Name can not be empty");
      if (this.data.categoryIcon.trim() == "")
        return this.message("error", "Please upload category icon");
      this.data.categoryIcon = `${this.data.categoryIcon}`;
      this.isAdding = true;
      const res = await this.ExecuteMethod(
        "post",
        "/app/create_category",
        this.data
      );
      if (res.status == 201) {
        this.isAdding = false;
        this.categories.unshift(res.data);
        this.message("success", "Category was added successfully.");
        this.Addmodal = false;
        this.$refs.uploads.clearFiles();
        this.data.categoryIcon = "";
        this.data.categoryName = "";
      }
      if ((res.status = 422)) {
        this.isAdding = false;
        if (res.data.errors.categoryIcon) {
          this.message("error", res.data.errors.categoryIcon[0]);
        }
        if (res.data.errors.categoryName) {
          this.message("error", res.data.errors.categoryName[0]);
        }
      } else {
        this.isAdding = false;
        this.swr();
      }
    },
    // end method to add new category
    // method to modify category
    async editcategory() {
      if (this.editdata.categoryName.trim() == "")
        return this.message("error", "category Name can not be empty");
      if (this.editdata.categoryIcon.trim() == "")
        return this.message("error", "Please upload category icon");
      this.isAdding = true;
      const res = await this.ExecuteMethod(
        "post",
        "/app/edit_category",
        this.editdata
      );
      if (res.status == 200) {
        this.isAdding = false;
        this.categories[this.index].categoryName = this.editdata.categoryName;
        this.categories[this.index].categoryIcon = this.editdata.categoryIcon;
        this.message("success", "category was edited successfully.");
        this.Editmodal = false;
        this.isIconimagenew = false;
     
      }
      if ((res.status = 422)) {
        this.isAdding = false;
        if (res.data.errors.categoryName) {
          this.message("error", res.data.errors.categoryName[0]);
        }
        if (res.data.errors.categoryIcon) {
          this.message("error", res.data.errors.categoryIcon[0]);
        }
      } else {
        this.isAdding = false;
        this.swr();
      }
    },
    // end method to modify category
    showeditmodal(category, index) {
      let obj = {
        id : category.id,
        categoryIcon : category.categoryIcon,
        categoryName : category.categoryName
      }
      this.editdata = obj;
      this.Editmodal = true;
      this.index = index;
      this.iseditingItem = true;
    },
    async deletecategory(category, i) {
      this.isDeleting = true;
      const res = await this.ExecuteMethod(
        "post",
        "/app/delete_category",
        this.deleteitem
      );
      if (res.status == 200) {
        this.categories.splice(this.deletingIndex, 1);
        this.message("success", "category Name was deleted successfully.");
      } else {
        this.swr();
      }
      this.isDeleting = false;
      this.deletemodal = false;
    },
    showdeletingmodal(category, i) {
      this.deleteitem = category;
      this.deletingIndex = i;
      this.deletemodal = true;
    },
    closeEditmodal() {
      if(this.standbyImage) {
        this.editdata.categoryIcon = this.recoveryimage
    
      }
     
      this.iseditingItem = false;
      this.Editmodal = false;
      this.isIconimagenew = false;
      
      
    },
  },

  async created() {
    this.token = window.Laravel.csrfToken;
    const res = await this.ExecuteMethod("get", "/app/get_categories");
    if (res.status == 200) {
      this.categories = res.data;
    } else {
      this.swr();
    }
  },
};
</script>

<style>
.demo-upload-list {
  display: inline-block;
  width: 100px;
  height: 100px;
  text-align: center;
  line-height: 60px;
  border: 1px solid transparent;
  border-radius: 4px;
  overflow: hidden;
  background: #fff;
  position: relative;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
  margin-right: 4px;
}
.demo-upload-list img {
  width: 100%;
  height: 100%;
}
.demo-upload-list-cover {
  display: none;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.6);
}
.demo-upload-list:hover .demo-upload-list-cover {
  display: block;
}
.demo-upload-list-cover i {
  color: #fff;
  font-size: 20px;
  cursor: pointer;
  margin: 0px 2px;
}
</style>