<template>

	<div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
		  <li class="breadcrumb-item">
            <router-link to="/today-order">Today's Orders</router-link>
          </li>
          <li class="breadcrumb-item active">Order Details</li>
        </ol>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-2">
              <span class="m-0 font-weight-bold text-primary">Order #{{ orders.id }}</span>
              <a :href=" '/api/invoice-view/'+orders.id" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="add_new"><i class="fas fa-download fa-sm text-white-50"></i> Generate Invoice</a>
            </div>
            <div class="card-body">

				<div class="row">
             		<div class="col-lg-6 col-md-6 col-6">
             			<ul class="list-group">
						  <li class="list-group-item bg-primary text-white text-center">Customer Details</li>
						  <li class="list-group-item">
								<table class="table table-bordered" >
									<tr>
										<td>Name</td>
										<td>{{ orders.customer.name }}</td>
									</tr>
									<tr>
										<td>Phone</td>
										<td>{{ orders.customer.phone }}</td>
									</tr>
									<tr>
										<td>Email</td>
										<td>{{ orders.customer.email }}</td>
									</tr>
									<tr>
										<td>Address</td>
										<td>{{ orders.customer.address }}</td>
									</tr>
									<tr>
										<td>Photo</td>
										<td>
											<img :src="'/backend/uploads/customer/' + orders.customer.photo" id="imgstyle">
										</td>
									</tr>
								</table>
						  </li>
						</ul>

             		</div>
             		<div class="col-lg-6 col-md-6 col-6">
             			<ul class="list-group">
						  <li class="list-group-item bg-primary text-white text-center">ORDER DETAILS</li>
						  <li class="list-group-item">
							  	<table class="table table-bordered" >
									<tr>
										<td>Order Id</td>
										<td>{{ orders.id }}</td>
									</tr>
									<tr>
										<td>Order Date</td>
										<td>{{ orders.order_date }}</td>
									</tr>
									<tr>
										<td>Order Quantity</td>
										<td>{{ orders.qty }}</td>
									</tr>
									<tr>
										<td>Pay by</td>
										<td>{{ orders.payby }}</td>
									</tr>
									<tr>
										<td>Total Amount</td>
										<td>{{ orders.total }} Taka</td>
									</tr>
								</table>
						  </li>
						</ul>

             		</div>
             	</div>

				<div class="table-responsive">
					<br>
					<h3>Products:</h3>
	                <table class="table table-bordered" width="100%" cellspacing="0">
	                  <thead>
	                    <tr class="text-center">
	                      <th>Name</th>
	                      <th>Code</th>
	                      <th>Image</th>
	                      <th>Unit Price</th>
	                      <th>Quantity</th>
	                      <th>Line Total</th>
	                    </tr>
	                  </thead>
	                
	                  <tbody>
	                    <tr v-for="detail in details" :key="detail.product.id" class="text-center">
	                      <td>{{ detail.product.name }}</td>
	                      <td>{{ detail.product.code }}</td>
	                      <td><img :src="'/backend/uploads/product/'+detail.product.photo" id="em_photo"></td>
	                      <td>{{ detail.product_price }} Taka</td>
	                      <td>{{ detail.product_qty }}</td>
	                      <td>{{ detail.sub_total }} Taka</td>
	                    </tr> 
	                  </tbody>
	                </table>
              	</div>

				<div class="row">
             		<div class="col-lg-8 col-md-7 col-sm-12"></div>
             		<div class="col-lg-4 col-md-5 col-sm-12">
						 <table class="table table-bordered" >
							<tr>
								<td>Sub Total</td>
								<td>{{ orders.sub_total }} Taka</td>
							</tr>
							<tr>
								<td>Vat </td>
								<td>{{ orders.vat }}%</td>
							</tr>
							<tr>
								<td class="text-success">Grand Total</td>
								<td class="text-success">{{ orders.total }} Taka</td>
							</tr>
							<tr>
								<td>Pay Amount</td>
								<td v-if="orders.due == 0" class="text-center"><p style="border:1px solid green;">FULL PAID</p></td>
								<td v-else>{{ orders.pay }} Taka</td>
							</tr>
							<tr v-if="orders.due > 0">
								<td class="text-danger">Due Amount</td>
								<td class="text-danger">{{ orders.due }} Taka</td>
							</tr>
						</table>
					</div>
				</div>

            </div>
          </div>

        </div>  
  </div>

</template>



<script type="text/javascript">
 export default { 

      created(){
            if(!User.loggedIn()){
              this.$router.push({ name: '/' })
            }else{
              this.getOrder(),
              this.OrderDetails()
            }
      },

      data(){
          return{
        		errors:{},
        		orders:{},
        		details:{},
        	}
      },

      methods:{
			getOrder(){
				let id = this.$route.params.id
				axios.get('/api/order-details/'+id)
				.then(({data}) => (
					this.orders = data
					
				))
				.catch(error => {
					Toast.fire({
						icon: 'error',
						title: 'Something went wrong!'
					})

				})
			},

			OrderDetails(){
				let id = this.$route.params.id
				axios.get('/api/orderdetails/'+id)
				.then(({data}) => (
					this.details = data
					
					))
				.catch(error => {
					Toast.fire({
						icon: 'error',
						title: 'Something went wrong!'
					})

				})
			},
		

      }

  }
</script>



<style type="text/css">
	
  #em_photo{
  height: 40px;
  width: 40px;
}
  #imgstyle{
  height: 50px;
  width: 50px;
  border: 1px solid grey;
  padding: 0px;
  border-radius: 5px;
}
  .dataTables_empty{
    display: none;
  }

</style>