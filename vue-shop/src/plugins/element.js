import Vue from 'vue'
import {
  Form,
  Input,
  Icon,
  Message,
  Button,
  FormItem,
  Table,
  TableColumn,
  Container,
  Header,
  Aside,
  Main,
  Menu,
  MenuItem,
  MenuItemGroup,
  Submenu,
  Breadcrumb,
  BreadcrumbItem,
  Card,
  Col,
  Row,
  Switch,
  ButtonGroup,
  Pagination,
  Dialog,
  MessageBox,
  Tag
} from 'element-ui'
Vue.use(Button)
Vue.use(Form)
Vue.use(FormItem)
Vue.use(Input)
Vue.use(Icon)
Vue.use(Table)
Vue.use(TableColumn)
Vue.use(Container)
Vue.use(Header)
Vue.use(Aside)
Vue.use(Main)
Vue.use(Menu)
Vue.use(MenuItem)
Vue.use(MenuItemGroup)
Vue.use(Submenu)
Vue.use(Breadcrumb)
Vue.use(BreadcrumbItem)
Vue.use(Card)
Vue.use(Col)
Vue.use(Row)
Vue.use(Switch)
Vue.use(ButtonGroup)
Vue.use(Pagination)
Vue.use(Dialog)
Vue.use(Tag)
// 弹窗需要挂载
Vue.prototype.$alert = Message
// 确认框
Vue.prototype.$confirm = MessageBox.confirm
