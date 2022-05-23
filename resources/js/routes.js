
//Authentication
let Login = require('./components/auth/login.vue').default;
let Register = require('./components/auth/register.vue').default;
let Forget = require('./components/auth/forget.vue').default;
let Logout = require('./components/auth/logout.vue').default;
let Reset = require('./components/auth/reset.vue').default;
let Home = require('./components/home.vue').default;
//Employee
let Employee = require('./components/employee/index.vue').default;
let AddEmployee = require('./components/employee/add.vue').default;
let EditEmployee = require('./components/employee/edit.vue').default;
//Supplier
let Supplier = require('./components/supplier/index.vue').default;
let AddSupplier = require('./components/supplier/add.vue').default;
let EditSupplier = require('./components/supplier/edit.vue').default;
//Category
let Category = require('./components/category/index.vue').default;
let AddCategory = require('./components/category/add.vue').default;
let EditCategory = require('./components/category/edit.vue').default;
//Product
let Product = require('./components/product/index.vue').default;
let AddProduct = require('./components/product/add.vue').default;
let EditProduct = require('./components/product/edit.vue').default;
//Stock
let Stock = require('./components/product/stock.vue').default;
let EditStock = require('./components/product/edit-stock.vue').default;
//Expense
let Expense = require('./components/expense/index.vue').default;
let AddExpense = require('./components/expense/add.vue').default;
let EditExpense = require('./components/expense/edit.vue').default;
//Salary
let Salary = require('./components/salary/index.vue').default;
let GiveSalary = require('./components/salary/all-employee.vue').default;
let AddSalary = require('./components/salary/add.vue').default;
let EditSalary = require('./components/salary/edit.vue').default;
//Customer =====================
let Customer = require('./components/customer/index.vue').default;
let AddCustomer = require('./components/customer/add.vue').default;
let EditCustomer = require('./components/customer/edit.vue').default;
//Point of Sale 
let PointOfSale = require('./components/pos/index.vue').default;
//Order
let Order = require('./components/order/index.vue').default;
let SearchOrder = require('./components/order/search.vue').default;
let ViewOrder = require('./components/order/view.vue').default;
//Settings
let Settings = require('./components/settings/index.vue').default;
//Report
let TodayReport = require('./components/report/today.vue').default;
let SearchReport = require('./components/report/search.vue').default;


export const routes = [
    { path: '/', component: Login, name: '/'},
    { path: '/register', component: Register, name: 'register' },
    { path: '/forget', component: Forget, name: 'forget' },
    { path: '/logout', component: Logout, name: 'logout' },
    { path: '/response-password-reset/:token', component: Reset, name: 'reset' },
    { path: '/home', component: Home, name: 'home' },
    //Employee Routes
    { path: '/employee', component: Employee, name: 'employee' },
    { path: '/add-employee', component: AddEmployee, name: 'add-employee' },
    { path: '/edit-employee/:id', component: EditEmployee, name: 'edit-employee' },
    //Supplier Routes
    { path: '/supplier', component: Supplier, name: 'supplier' },
    { path: '/add-supplier', component: AddSupplier, name: 'add-supplier' },
    { path: '/edit-supplier/:id', component: EditSupplier, name: 'edit-supplier' },
    //Category Routes
    { path: '/category', component: Category, name: 'category' },
    { path: '/add-category', component: AddCategory, name: 'add-category' },
    { path: '/edit-category/:id', component: EditCategory, name: 'edit-category' },
    //Product Routes
    { path: '/product', component: Product, name: 'product' },
    { path: '/add-product', component: AddProduct, name: 'add-product' },
    { path: '/edit-product/:id', component: EditProduct, name: 'edit-product' },
    //Stock Routes
    { path: '/stock', component: Stock, name: 'stock' },
    { path: '/edit-stock/:id', component: EditStock, name: 'edit-stock' },
    //Expense Routes
    { path: '/expense', component: Expense, name: 'expense' },
    { path: '/add-expense', component: AddExpense, name: 'add-expense' },
    { path: '/edit-expense/:id', component: EditExpense, name: 'edit-expense' },
    //Salary Routes
    { path: '/salary', component: Salary, name: 'salary' },
    { path: '/give-salary', component: GiveSalary, name: 'give-salary' },
    { path: '/add-salary/:id', component: AddSalary, name: 'add-salary' },
    { path: '/edit-salary/:id', component: EditSalary, name: 'edit-salary' },
    //Customer Routes
    { path: '/customer', component: Customer, name: 'customer' },
    { path: '/add-customer', component: AddCustomer, name: 'add-customer' },
    { path: '/edit-customer/:id', component: EditCustomer, name: 'edit-customer' },
    //Point of Sale Routes
    { path: '/pos', component: PointOfSale, name: 'pos' },
    //Order Routes
    { path: '/today-order', component: Order, name: 'order' },
    { path: '/search-order', component: SearchOrder, name: 'search-order' },
    { path: '/view-order/:id', component: ViewOrder, name: 'view-order' },
    //Settings Routes
    { path: '/settings', component: Settings, name: 'settings' },
    //Report Routes
    { path: '/today-report', component: TodayReport, name: 'today-report' },
    { path: '/search-report', component: SearchReport, name: 'search-report' },

  ]