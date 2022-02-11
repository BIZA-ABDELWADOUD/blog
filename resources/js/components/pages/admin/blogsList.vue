

<template>
  <div>
    <!-- container fluid -->
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3 class="m-0">List Of Blogs</h3>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active">List Of Blogs</li>
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
            <Button size="small" type="primary" @click="$router.push('/blogs')"
              ><Icon type="md-add" />
              Create New Blog
            </Button>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Categories</th>
                  <th>Tags</th>
                  <th>Creation</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(blog,i) in blogs" :key="i" v-if="blogs.length">
                  <td>{{i+1}}</td>
                  <td>{{blog.title}}</td>
                  <td v-if="blog.categories.length">
                    <span v-for="(cat,i) in blog.categories" :key="i"> <Tag color="green">{{cat.categoryName}}</Tag></span>
                    </td>
                  <td v-if="blog.tags.length">
                    <span v-for="(tag,i) in blog.tags" :key="i"><Tag color="green">{{tag.tagName}}</Tag></span> 
                    </td>
                  <td>{{ moment(blog.created_at).fromNow() }}</td>
                  <td>
                    <Button size="small" type="primary" @click="">View</Button>
                    <Button size="small" type="warning" @click="showeditmodal(blog,i)" v-if="isUpdatePermitted">Edit</Button>
                    <Button size="small" type="error" @click="showdeletingmodal(blog,i)" v-if="isDeletePermitted" :loading="blog.isDeleting">Delete</Button>
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


    <!-- modal to delete blog -->
     <Modal v-model="deletemodal" width="360">
        <p slot="header" style="color:#f60;text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span> confirmation</span>
        </p>
        <div style="text-align:center">
          <p>Are you sure to delete the blog : <span style="color:#ed4014">{{deleteitem.blogName}}</span> ?</p>
        </div>
        <div slot="footer">
            <Button type="error" size="large" long :disabled="isDeleting" :loading="isDeleting" @click="deleteblog">{{isDeleting ? 'Deleting...' : 'Delete'}}</Button>
        </div>
    </Modal>
    <!-- end modal to delete blog -->


  </div>
  <!-- /.content-wrapper -->
</template>

<script>

export default {
  data() {
    return {
      blogs : [],
      index : -1,
      deletemodal : false,
      deleteitem : {},
      deletingIndex : -1,
      
      isDeleting :false
    };
  },

  methods: {

    async deleteblog(blog,i) {
      this.isDeleting = true
      const res = await this.ExecuteMethod('post','/app/delete_blog',this.deleteitem)
      if(res.status==200) {
        this.blogs.splice(this.deletingIndex,1)
        this.message("success", "blog Name was deleted successfully.")
      }
      else {
        this.swr();
      }
       this.isDeleting = false
       this.deletemodal = false
    },
    showdeletingmodal(blog,i) {
      this.deleteitem = blog
      this.deletingIndex = i
      this.deletemodal = true
    }
  },

  async created() {
    const res = await this.ExecuteMethod("get", "/app/blogsdata");
    if (res.status == 200) {
      this.blogs = res.data 
    } 
    
    else {
      this.swr()
    }
  },
};
</script>