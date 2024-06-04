
/**
 * Валидатор.
 *
 * @type {Object}
 */
ko.validation = new (function () {

    /**
     * Функция валидации моделей.
     *
     * @return {Boolean}
     */
    var isValid = function () {
        this.validate(true);
        // Цикл по наблюдаемым свойствам модели
        for (var opt in this) if (ko.isObservable(this[opt])) {
            // Если поле содержит ошибку
            if (this[opt].isError != undefined && this[opt].isError() == true) {
                console.log(opt + ': ' + this[opt].message());
                return false;
            }
        }
        return true;
    };

    return {
        /**
         * Инициализация валидатора.
         *
         * @param AppViewModel Экземпляр модели приложения.
         * @param annotations Аннотации полей сущности.
         */
        init: function (AppViewModel, annotations) {

            AppViewModel.validate = ko.observable(false);

            var asserts, options;

            // Цикл по полям для которых есть ограничения
            for (var field in annotations) if (annotations.hasOwnProperty(field)) {
                asserts = annotations[field];

                // Если в модели(AppViewModel) существует нужное свойство и оно является наблюдаемым
                if (AppViewModel[field] != undefined && ko.isObservable(AppViewModel[field])) {

                    AppViewModel[field].isError = ko.observable();  // Флаг наличия ошибки
                    AppViewModel[field].message = ko.observable();  // Сообщение об ошибке

                    // Цикл по ограничениям для поля
                    for (var i in asserts) if (asserts.hasOwnProperty(i)) {
                        options = {};
                        options[i] = asserts[i];                    // Опции валидатора
                        options[i]['asserts'] = asserts;            // Ссылка на ограничения
                        options[i]['AppViewModel'] = AppViewModel;  // Ссылка на модель
                        // Раширение наблюдаемого значения валидатором
                        AppViewModel[field].extend(options);
                    }
                }
            }

            // Примешать к модели функцию валидации
            AppViewModel.isValid = isValid;
        },

        /**
         * Добавляет новый тип ограничений.
         *
         * @param name Имя ограничения.
         * @param validate Фаункция валидации.
         * @param checkAsserts
         */
        addAssert: function (name, validate, checkAsserts) {
            // Регистрация extender'а
            ko.extenders[name] = function(target, option) {
                // Вычислять в зависимости от "AppViewModel.validate"
                ko.computed(function () {
                    // Если поле не валидно и для модели запрошена валидация
                    if  (validate(target, option) === false && option.AppViewModel.validate()) {
                        checkAsserts = checkAsserts || new Function('t,o', 'return false');
                        // Если нет других ограничений
                        if (checkAsserts(target, option) === false) {
                            target.isError(true);               // Флаг наличия ошибки
                            target.message(option.message);     // Сообщение об ошибке
                            target.typeError = name;            // Тип ошибки
                        }
                        return;
                    }
                    // Снять флаг ошибки может только валидатор установивший его
                    if (target.isError.peek() === true && target.typeError === name) {
                        target.isError(false);
                    }
                });
                return target;
            };
        }
    }

})();

// NotBlank
ko.validation.addAssert('NotBlank', function (target, option) {
    return (target().length > 0);
});


// MinLength
ko.validation.addAssert(

    'MinLength',

    function (target, option) {
        return (target().length >= option.limit);
    },

    function (target, option) {
        // В случае истины ошибку установит валидатор "NotBlank"
        return (target().length === 0 && option.asserts.NotBlank !== undefined);
    }
);


// MaxLength
ko.validation.addAssert('MaxLength', function (target, option) {
    return (target().length <= option.limit);
});


var _ANNOTATIONS_  = {
    name: {
        NotBlank: {
            message: 'Заполните поле'
        },
        MinLength: {
            limit: 3,
            message: 'Имя должно содержать не менее 3х символов'
        },
        MaxLength: {
            limit: 5,
            message: 'Имя должно содержать не более 5 символов'
        }
    },
    mail: {
        NotBlank: {
            message: 'Заполните поле' 
        }
    }
};


var AppViewModel = new (function () {
    var self  = this;                   // Ссылка на текущий контекст
    this.name = ko.observable('');      // Имя пользователя
    this.mail = ko.observable('');      // E-mail

    // Инициализация валидатора
    ko.validation.init(self, _ANNOTATIONS_);

    // Обработчик отправки формы
    this.submit = function () {
        if (self.isValid()) {
            alert('Модель валидна');
        } else {
            alert('Модель НЕ валидна');
        }
    };
})();


onload = function () {
    ko.applyBindings(AppViewModel, document.getElementById('myform'));
};


