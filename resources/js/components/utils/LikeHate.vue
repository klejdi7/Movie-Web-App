<template>

    <div>
    
        <a class="btn btn-success" v-if="isLiked" @click="retractVote(1)"> <i class="fas fa-thumbs-up"></i> Like </a>

        <a class="btn btn-outline-success" v-else-if="!isLiked&&!voted" @click="likeItem()" > <i class="fas fa-thumbs-up"></i> Like </a>

        <a class="btn btn-danger" v-if="isHated" @click="retractVote(0)"> <i class="far fa-thumbs-down" ></i> Hate </a>

        <a class="btn btn-outline-danger" v-else-if="!isHated&&!voted"  @click="hateItem()" > <i class="far fa-thumbs-down"></i> Hate </a>

    </div>      
             
</template>

<script>
export default {

    props : {
        itemID : {
            type: Number
        },
        action : {
            type: String
        }
    },

    data () {
        return {
            post: {},
            likes: 0,
            hates: 0,
            isLiked: true,
            isHated: true,
            voted: false,
        }
    },

    watch : {
        // isLiked : function() {},
        // isHated : function() {},

     },

    created: function () {
        this.checkLiked();
    },

    methods: {

        checkLiked : function(){
                    
            var postData = new FormData();
            postData.append('id', this.itemID);
            postData.append('user_id', this.$root.user.id);

                this.axios.post('/api/checkLiked', postData).then(response => {    

                    if(response.data.type == 1) {
                        this.isLiked = true;
                        this.isHated = false;

                    } else if(response.data.type === 0) {
                        this.isHated = true;
                        this.isLiked = false;
                    }

                })
                .catch(e => {
                this.isLiked = false;
                this.isHated = false;
                this.voted = false;
            });          

        },

        retractVote: function(type) {

            var postData = new FormData();
            postData.append('id', this.itemID);
            postData.append('user_id', this.$root.user.id);
            postData.append('type', type);

            this.axios.post('/api/retractVote', postData).then(response => {    
                this.$emit('callback');
                
            })
                .catch(e => {
                console.log(e.response.data);
            });

            if(type == 1) {

                this.isLiked = false;

            } else if (type == 0) {

                this.isHated = false;
                
            }

                this.voted = false;
        },

        likeItem: function(){
                    
            var postData = new FormData();
            postData.append('post_id', this.itemID);
            postData.append('user_id', this.$root.user.id);

            this.axios.post('/api/likeItem', postData).then(response => {    
                this.$emit('callback');
                this.$emit(this.checkLiked());
                })
                .catch(e => {
            }); 
                    
        },
        
        hateItem: function(){
                    
            var postData = new FormData();
            postData.append('post_id', this.itemID);
            postData.append('user_id', this.$root.user.id);

            this.axios.post('/api/hateItem', postData).then(response => {    
                this.$emit('callback');
                this.$emit(this.checkLiked());                  
                    })
                .catch(e => {
            }); 
        }

    }

}
</script>