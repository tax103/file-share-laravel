/**
 * Vue.js with form-backend-validation の初期定義
 * 
 * @param {object} option data.fields を含む Vue へ渡すオプション
 * @param {string} url    フォームのポスト先URL
 */
export function formBackendValidation(option, url) {
    const app = new Vue(merge({
      el: '#app',
      data: {
        form: new Form(option.data.fields),
        message: '',
        messageClass: ''
      },
      methods: {
        onSubmit() {
          this.form['post'](url)
            .then(res => {
              if (res.redirect) {
                location.href = res.redirect
              } else if (res.message) {
                this.displayMessage(message, true);
              } else {
                this.displayMessage('更新しました。', true);
              }
            })
            .catch(res => this.displayMessage('エラーを確認してください。', false));
        },
        displayMessage(message, success) {
          this.messageClass = 'alert-' + (success ? 'success' : 'danger')
          this.message = message;
        },
        clearMessage() {
          this.message = '';
        },
      },
    }, option));
    return app;
  }
  
  /**
   * deep merge
   */
  function merge() {
    return [].reduce.call(arguments, function merge(a, b) {
      Object.keys(b).forEach(function (key) {
        a[key] = (typeof a[key] === "object" && typeof b[key] === "object")
          ? a[key] = merge(a[key], b[key]) : a[key] = b[key];
      });
      return a;
    });
  }