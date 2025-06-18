import * as yup from "yup";

const registrationSchema = yup.object({
    title: yup.string().required("Title is required"),
    fullname: yup.string().required("Full name is required"),
    position: yup.string().nullable(),
    organization: yup.string().required("Organization is required"),
    address: yup.string().required("Billing address is required"),
    country: yup.string().required("Country is required"),
    phone: yup.string().required("Phone number is required"),
    email: yup
        .string()
        .email("Invalid email format")
        .required("Email is required"),
    dietary_requirement: yup
        .string()
        .required("Please select a dietary requirement"),
    other_dietary_requirement: yup.string().when("dietary_requirement", {
        is: (dietary_requirement) => dietary_requirement == "Other",
        then: (schema) => schema.required("Please specify your dietary"),
        otherwise: (schema) => schema.nullable(),
    }),
    other_title: yup.string().when("title", {
        is: (title) => title == "Other",
        then: (schema) => schema.required("Please specify your title"),
        otherwise: (schema) => schema.nullable(),
    }),
    conference_type: yup.string().required("Please select a conference type"),
    paper_title: yup.string().when("conference_type", {
        is: (type) =>
            type == "attendance" ||
            type == "abstract" ||
            type == "iop" ||
            type == "stdj",
        then: (schema) => schema.required("Paper title is required"),
        otherwise: (schema) => schema.nullable(),
    }),
    payment_method: yup.string().required("Please select a payment method"),
});

window.registrationForm = function () {
    return {
        form: {
            title: "",
            other_title: "",
            fullname: "",
            position: "",
            organization: "",
            address: "",
            country: "",
            phone: "",
            email: "",
            dietary_requirement: "",
            other_dietary_requirement: "",
            conference_type: "",
            paper_title: "",
            payment_method: "",
            register_type: "international",
        },
        errors: {},
        countries: {},
        async init() {
            this.countries = await this.getListCountry();
        },
        async getListCountry() {
            // Gọi helper từ backend nếu cần
            const res = await fetch("/get-list-countries"); // hoặc route nào đó ông set sẵn
            const data = await res.json();
            return data;
        },
        async submitForm() {
            if (this.isSubmitting) return; // Ngăn submit nếu đang gửi

            this.errors = {};
            this.isSubmitting = true; // Bắt đầu gửi

            try {
                await registrationSchema.validate(this.form, {
                    abortEarly: false,
                });
                console.log("send");

                const response = await fetch(
                    "/registration-international-submit",
                    {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                        body: JSON.stringify(this.form),
                    }
                );

                const result = await response.json();

                if (result.status === "redirect" && result.url) {
                    window.location.href = result.url;
                } else {
                    console.log("Đăng ký thành công");
                }
                if (response.ok) {
                    alert("Registration successful!");
                }
            } catch (err) {
                if (err.name === "ValidationError") {
                    err.inner.forEach((e) => {
                        this.errors[e.path] = e.message;
                    });
                }
                console.log(err);
            } finally {
                this.isSubmitting = false; // Cho phép submit lại sau khi xong
            }
        },
    };
};
