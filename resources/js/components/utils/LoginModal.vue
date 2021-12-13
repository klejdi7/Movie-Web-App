<template>

    <div>

		<a data-bs-toggle="modal" href="#" class="text-dark nav-link" disabled data-bs-target="#userModal" >
		
			Login

		</a>

  		<div class="modal fade " id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			
			<div class="modal-dialog">
	  			
				<div class="modal-content">
					
					<div class="modal-header">
		 	 			
						<h5 class="modal-title" id="exampleModalLabel">Login User</h5>
		  				
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					
					</div>

					<div class="modal-body">

		  					<div class="alert alert-danger d-flex align-items-center" role="alert" v-if="errors !== null" v-for="error in errors">
								{{error}} 
							</div>

						  	<div>
							
								<form>

									<div class="row mb-3">
																					
										<div class="input-group mb-3">
  										
										  	<span class="input-group-text" id="basic-addon1">Email</span>
  							
							  				<input type="email" class="form-control" placeholder="Email please" v-model="user.email" name="email" aria-label="Username" aria-describedby="basic-addon1">
										
										</div>
									
									</div>

  									<div class="row mb-3">
    								
										<div class="input-group mb-3">
  										
										  	<span class="input-group-text" id="basic-addon1">Password</span>
  							
							  				<input type="password" class="form-control" placeholder="Enter Password please" v-model="user.psw" name="psw"  aria-label="Username" aria-describedby="basic-addon1">
										
										</div>
					
									</div>

								</form>

							</div>

						</div>

						<div class="modal-footer">
			
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			
							<button type="button" class="btn btn-primary" @click="loginUser()">Sign in</button>
			
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
        user: {},
		errors : null,
        }
    },

	mounted : function(){ },

	watch: {},

    methods: {
        loginUser: function() {

			this.axios.post('/data/login', this.user).then(response => {     
					
				location.reload();
				
				})

				.catch(e => {
						this.errors = e.response.data;
			});           
		}
	},
}

</script>