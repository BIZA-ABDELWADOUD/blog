

<template>
  <div>
    <!-- container fluid -->
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3 class="m-0">Blogs Page</h3>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active">Blogs Page</li>
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
       

        <div class="mt-2 mb-2">
          <Input type="text" v-model="data.title" placeholder="Enter your title"></Input>
        </div>

         <div class="card">
          <!-- /.card-header -->

          <div class="blog_editor" style="">
            <editor
              ref="editor"
              autofocus
              holder-id="codex-editor"
              save-button-id="save-button"
              :init-data="initData"
              
              :config="config"
            />
          </div>
          <!-- /.card-body -->
        </div>

        <div class="mt-2">
          <Input type="textarea" :rows="4" v-model="data.post_excerpt" placeholder="Enter post excerpt" />
        </div>

        <div class="mt-2">
          <Select filterable multiple placeholder="Select category" v-model="data.category_id">
            <Option v-for="(cat, i) in categories" :value="cat.id" :key="i">{{
              cat.categoryName
            }}</Option>
          </Select>
        </div>

        <div class="mt-2">
          <Select filterable multiple placeholder="Select Tag" v-model="data.tag_id">
            <Option v-for="(tag, i) in tags" :value="tag.id" :key="i">{{
              tag.tagName
            }}</Option>
          </Select>
        </div>

         <div class="mt-2">
          <Input type="textarea" v-model="data.metaDescription" :rows="4" placeholder="Enter description" />
        </div>

        <div class="_input_field">
          <Button size="small" type="primary" @click="save"
            :loading="isCreating" :disabled="isCreating">{{isCreating ? "Creating..." : "Create Blog"}}
          </Button>
        </div>

        <!-- /.card -->
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
import List from "@editorjs/list";
import Table from "@editorjs/table";
import ImageTool from "@editorjs/image";
export default {
  data() {
    return {
      config: {
        tools: {
          image: {
            class: ImageTool,

            field: "image",
            types: "image/*",
          },
          quote: require("@editorjs/quote"),
          table: Table,
          list: {
            class: List,
            inlineToolbar: true,
          },
          header: require("@editorjs/header"),
        },
      },
      initData: null,
   
      data: {
        title: "",
        post: "",
        post_excerpt : "",
        metaDescription : "",
        category_id : [],
        tag_id : [],
        jsonData : null

      },
      articleHTML: "",
      categories: [],
      tags :[],
      isCreating :false,
    };
  },

  methods: {
    // methos to add new tag
    async addTag() {
      if (this.data.tagName.trim() == "")
        return this.message("error", "Tag Name can not be empty");
      this.isAdding = true;
      const res = await this.ExecuteMethod(
        "post",
        "/app/create_tag",
        this.data
      );
      if (res.status == 201) {
        this.isAdding = false;
        this.tags.unshift(res.data);
        this.message("success", "Tag Name was added successfully.");
        this.Addmodal = false;
        this.data.tagName = "";
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

     save() {
      this.$refs.editor._data.state.editor
        .save()
        .then((data) => {
         this.outputHtml(data.blocks)
         this.data.post = this.articleHTML
         this.data.jsonData = JSON.stringify(data)
        if(this.data.title.trim() == '') return this.message('error','The title is required')
        if(this.data.post.trim() == '') return this.message('error','The post is required')
        if(this.data.post_excerpt.trim() == '') return this.message('error','The post excerpt is required')
        if(this.data.metaDescription.trim() == '') return this.message('error','The description is required')
        if(!this.data.category_id.length) return this.message('error','The category is required')
        if(!this.data.tag_id.length) return this.message('error','The tag is required')
        this.isCreating = true
        const resblog =  this.ExecuteMethod('post','/app/create-blog',this.data)
        if(resblog.status = 200) {
          this.message('success','added successfuly')
          console.log('it is working')
        } else {
          this.swr()
          console.log('it is not working')
        }
        });
    },
    outputHtml(articleObj) {
      articleObj.map((obj) => {
        switch (obj.type) {
          case "paragraph":
            this.articleHTML += this.makeParagraph(obj);
            break;
          case "image":
            this.articleHTML += this.makeImage(obj);
            break;
          case "header":
            this.articleHTML += this.makeHeader(obj);
            break;
          case "raw":
            this.articleHTML += `<div class="ce-block">
					<div class="ce-block__content">
					<div class="ce-code">
						<code>${obj.data.html}</code>
					</div>
					</div>
				</div>\n`;
            break;
          case "code":
            this.articleHTML += this.makeCode(obj);
            break;
          case "list":
            this.articleHTML += this.makeList(obj);
            break;
          case "quote":
            this.articleHTML += this.makeQuote(obj);
            break;
          case "warning":
            this.articleHTML += this.makeWarning(obj);
            break;
          case "checklist":
            this.articleHTML += this.makeChecklist(obj);
            break;
          case "embed":
            this.articleHTML += this.makeEmbed(obj);
            break;
          case "delimeter":
            this.articleHTML += this.makeDelimeter(obj);
            break;
          default:
            return "";
        }
      });
    },
  },
  async created() {
    const [cat,tag] = await Promise.all([
       this.ExecuteMethod("get", "/app/get_categories"),
         this.ExecuteMethod("get", "/app/get_tags")
    ])
    
    if (cat.status == 200) {
      this.categories = cat.data,
      this.tags = tag.data
    } else {
      this.swr();
    }
  },
};
</script>