// 进行多语言支持配置
import Vue from 'vue' // 引入Vue
import VueI18n from 'vue-i18n' // 引入国际化的插件包
import locale from 'element-ui/lib/locale'
import elementEN from 'element-ui/lib/locale/lang/en' // 引入饿了么的英文包
import elementZH from 'element-ui/lib/locale/lang/zh-CN' // 引入饿了么的中文包
import businessEN from './en.js'  //引入业务相关的英文包
import businessZH from './zh.js'  //引入业务相关的中文包
Vue.use(VueI18n) // 全局注册国际化包
 
// 创建国际化插件的实例
const i18n = new VueI18n({
  // 指定语言类型 zh表示中文  en表示英文
  locale: 'zh',
  // 将elementUI语言包加入到插件语言数据里
  messages: {
    // 英文环境下的语言数据
    en: {
      ...elementEN,
      ...businessEN
    },
    // 中文环境下的语言数据
    zh: {
      ...elementZH,
      ...businessZH
    }
  }
})
// 配置elementUI 语言转换关系
locale.i18n((key, value) => i18n.t(key, value))
 
export default i18n