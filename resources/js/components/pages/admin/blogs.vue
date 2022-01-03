

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
        <div class="card">
          <!-- /.card-header -->
          <div class="blog_editor">
            <editor
              ref="editor"
              :config="config"
              :initialized="onInitialized"
              @save="save"
            />
          </div>

          <!-- /.card-body -->
        </div>

        <div class="_input_field">
          <Input type="text" placeholder="Give your title"></Input>
        </div>

        <div class="_input_field" style="margin-top: 20px">
          <Button size="small" type="primary" @click="invokeSave"
            >Save The Blog
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

      data: {
        tagName: "",
      },
      articleHTML: '',
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

    async save(response) {
      var data = response
      await this.outputHtml(data.blocks)
			console.log(this.articleHtml)
    },

    async invokeSave() {
      // this.$refs.editor._data.state.editor.save();
      this.$refs.editor._data.state.editor
        .save()
        .then((data) => {
          // Do what you want with the data here
          console.log(data);
        
         
        })
        .catch((err) => {
          console.log(err);
        });
    },
   	 outputHtml(articleObj){
		   articleObj.map(obj => {
				switch (obj.type) {
				case 'paragraph':
					this.articleHTML += this.makeParagraph(obj);
					break;
				case 'image':
					this.articleHTML += this.makeImage(obj);
					break;
				case 'header':
					this.articleHTML += this.makeHeader(obj);
					break;
				case 'raw':
					this.articleHTML += `<div class="ce-block">
					<div class="ce-block__content">
					<div class="ce-code">
						<code>${obj.data.html}</code>
					</div>
					</div>
				</div>\n`;
					break;
				case 'code':
					this.articleHTML += this.makeCode(obj);
					break;
				case 'list':
					this.articleHTML += this.makeList(obj)
					break;
				case "quote":
					this.articleHTML += this.makeQuote(obj)
					break;
				case "warning":
					this.articleHTML += this.makeWarning(obj)
					break;
				case "checklist":
					this.articleHTML += this.makeChecklist(obj)
					break;
				case "embed":
					this.articleHTML += this.makeEmbed(obj)
					break;
				case 'delimeter':
					this.articleHTML += this.makeDelimeter(obj);
					break;
				default:
					return '';
				}
			});
		},
  },
};
</script>