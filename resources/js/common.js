import axios from "axios"
import { mapGetters } from "vuex"
export default {
    // data
    data() {
        return {

        }
    },
    // methods
    methods: {
        async ExecuteMethod(method, url, dataObj) {
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                })
            }
            catch (e) {
                return e.response
            }
        },
        // info(desc,title="Info") {
        //     this.$Notice.info({
        //       title: title,
        //       desc: desc,

               
        //     });
        //   },
        //   success(desc,title="Success") {
        //     this.$Notice.success({
        //       title: title,
        //       desc: desc,

        //     });
        //   },
           warning(desc,title="Warning") {
             this.$Notice.warning({
               title: title,
               desc: desc
             });
           },
           error(desc, title="Error") {
             this.$Notice.error({
               title: title,
               desc:desc,
               duration: 3
             });
           },
        //     swr(desc ="Something went wrong !", title="Oops") {
        //     this.$Notice.error({
        //       title: title,
        //       desc,desc
        //     });
        //   },

          message (type,content) {
            this.$Message[type]({
                background: true,
                content: content,
                duration: 3,
                closable: true
            });
        },

        
        swr () {
          this.$Message['warning']({
              background: true,
              content: 'Something went wrong ! retry',
              duration: 3,
              closable: true
          });
      },

      checkUserPermission(key) {
        if(!this.userpermissions) return false
        let isPermitted = false;
        for(let d of this.userpermissions) {
          if(this.$route.name == d.name) {
            if(d[key]) {
              isPermitted = true
              break;
            } else{
              break;
            }
          }
          
        }
        return isPermitted
      }
    },

    computed : {
      ...mapGetters({
       'userpermissions' : 'getUserPermission'
      }),
      isReadPermitted() {
        
        return this.checkUserPermission('read')
      },
      isWritePermitted() {
        return this.checkUserPermission('write')
      },
      isUpdatePermitted() {
        return this.checkUserPermission('update')

      },
      isDeletePermitted() {
        return this.checkUserPermission('delete')

      }
    }
}