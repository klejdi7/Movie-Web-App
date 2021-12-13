<template>

    <div>

		<a data-bs-toggle="modal" href="#" type="button" class="btn btn-success" disabled data-bs-target="#movieModal" >
		
			New Movie

		</a>

  		<div class="modal fade " id="movieModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			
			<div class="modal-dialog">
	  			
				<div class="modal-content">
					
					<div class="modal-header">
		 	 			
						<h5 class="modal-title" id="exampleModalLabel">Add new movie</h5>
		  				
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="success = false"></button>
					
					</div>

					<div class="modal-body">
		  				
                        <div class="alert alert-success d-flex align-items-center" role="alert" v-if="success">
							    Movie Added Successfully!
						</div>

						<div class="alert alert-danger d-flex align-items-center" role="alert" v-if="errors !== null" v-for="error in errors">
							{{error}} 
						</div>

						  	<div>
							
								<form>

									<div class="row mb-3">
																					
										<div class="input-group mb-3">
  										
										  	<span class="input-group-text" id="basic-addon1">Movie Title</span>
  							
							  				<input class="form-control" placeholder="Email Movie Title please" v-model="movie.title" name="title" aria-describedby="basic-addon1">
										
										</div>
									
									</div>

  									<div class="row mb-3">
    								
										<div class="input-group mb-3">
  										
										  	<span class="input-group-text" id="basic-addon1">Description</span>
  							
							  				<textarea  rows="4" cols="50" class="form-control" placeholder="Email Movie description please" v-model="movie.description" name="email"  aria-describedby="basic-addon1"></textarea>
										
										</div>
					
									</div>

								</form>

							</div>

						</div>

						<div class="modal-footer">
			
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="success = false" >Close</button>
			
							<button type="button" class="btn btn-success" @click="addMovie()">Post!</button>
			
						</div>

					</div>
		
				</div>

			</div>

  		</div>

</template>

<script>

export default {

    data() {
        return {
        movie: {},
        success: false,
		errors: null,
        }
    },

	mounted : function(){ },

	watch: {},

    methods: {
		
        addMovie: function() {

			var movieData = new FormData();
			movieData.append('title', this.movie.title || " ");
			movieData.append('description', this.movie.description || " ");
			movieData.append('user_id', this.$root.user.id);
			movieData.append('username', this.$root.user.username);

			this.axios.post('/api/posts', movieData).then(response => {     
					this.success = true;
					this.errors = [];
					this.$emit('callback');
					this.movie = [];
				})

				.catch(e => {
						this.errors = e.response.data;
			});           
		},
	}
}

</script>