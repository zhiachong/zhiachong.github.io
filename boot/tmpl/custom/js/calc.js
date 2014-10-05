var plan1 = {
    days: 20,
    daily: 1.4
};

var plan2 = {
    days: 30,
    daily: 1.7
};

var plan3 = {
    days: 60,
    daily: 2.1
};

var plan4 = {
    days: 90,
    daily: 2.5
};

var calc = {
    total_return_node: $('#total-return'),
    total_days_node: $('#total-days'),
    daily_node: $('#daily-profit'),
    compound: 30,
    cur_plan: plan1,
    amount: 10
};

calc.calculate = function () {

    var deposit = calc.amount * 100;
    var total_return = deposit;

    for (var i = 1; i <= calc.cur_plan.days; ++i) {

        var daily_interest = deposit * (calc.cur_plan.daily * 10);
        daily_interest = Math.round(daily_interest / 1000);

        total_return += daily_interest;

        var compound_amount = Math.round(daily_interest * calc.compound / 100);
        deposit += compound_amount;
    }

    total_return = total_return / 100;
    if(total_return > 9999) {
        total_return = Math.round(total_return)
    }
    calc.total_return_node.text(total_return);
}

calc.setPlan = function (plan) {
    this.cur_plan = plan;
    this.total_days_node.text(plan.days);
    this.daily_node.text(plan.daily);
}


$(document).ready(function () {

    var amount_slider = $('#amount-slider');
    var compound_slider = $('#compound-slider');
    var compound_val_text = $('#compound-val');
    var amount_val_text = $('#amount-val');

    amount_slider.slider({min: 10, max: 110, animate: 'slow',
        slide: function (event, ui) {

            var mult = 1;
            var value = ui.value;
            var diff = value - 10;
            var val = 10;

            for (var i = 1; i <= diff; ++i) {
                if (i > 90) {
                    mult = 3000;
                } else if (i > 80) {
                    mult = 1000;
                } else if (i > 70) {
                    mult = 500;
                } else if (i > 60) {
                    mult = 300;
                } else if (i > 50) {
                    mult = 100;
                } else if (i > 40) {
                    mult = 50;
                } else if (i > 30) {
                    mult = 20;
                } else if (i > 10) {
                    mult = 10;
                } else {
                    mult = 9;
                }
                val += mult;
            }

            if (val > 3000) {
                calc.setPlan(plan4)
            } else if (val > 1000) {
                calc.setPlan(plan3)
            } else if (val > 300) {
                calc.setPlan(plan2)
            } else {
                calc.setPlan(plan1)
            }


            calc.amount = val;
            amount_val_text.text(val);

            calc.calculate();
        }
    });


    compound_slider.slider({value: 0, step: 10, animate: 'slow',
        slide: function (event, ui) {

            var value = ui.value;

            calc.compound = value;
            compound_val_text.text(value);

            calc.calculate();
        }
    });

});