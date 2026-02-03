import React, { Component } from "react";
import { createRoot } from "react-dom/client";
import axios from "axios";
import Swal from "sweetalert2";
import { sum } from "lodash";

class Cart extends Component {
    constructor(props) {
        super(props);
        this.state = {
            cart: [],
            products: [],
            customers: [],
            barcode: "",
            search: "",
            customer_id: "",
            translations: {},
            loading: false,
        };

        // Bindings...
        this.loadCart = this.loadCart.bind(this);
        this.handleOnChangeBarcode = this.handleOnChangeBarcode.bind(this);
        this.handleScanBarcode = this.handleScanBarcode.bind(this);
        this.handleChangeQty = this.handleChangeQty.bind(this);
        this.handleEmptyCart = this.handleEmptyCart.bind(this);
        this.loadProducts = this.loadProducts.bind(this);
        this.handleChangeSearch = this.handleChangeSearch.bind(this);
        this.handleSeach = this.handleSeach.bind(this);
        this.setCustomerId = this.setCustomerId.bind(this);
        this.handleClickSubmit = this.handleClickSubmit.bind(this);
        this.loadTranslations = this.loadTranslations.bind(this);
    }

    componentDidMount() {
        this.loadTranslations();
        this.loadCustomers();
        this.loadProducts();
        this.loadCart();
    }

    // ─── API CALLS ────────────────────────────────────────
    loadTranslations() {
        axios.get("/admin/locale/cart").then((res) => {
            this.setState({ translations: res.data });
        }).catch(() => this.setState({ translations: {} }));
    }

    loadCustomers() {
        axios.get("/admin/customers").then((res) => {
            this.setState({ customers: res.data || [] });
        }).catch(() => this.setState({ customers: [] }));
    }

    loadProducts(search = "") {
        const query = search ? `?search=${encodeURIComponent(search)}` : "";
        axios.get(`/admin/products${query}`).then((res) => {
            this.setState({ products: res.data.data || [] });
        }).catch(() => this.setState({ products: [] }));
    }

    loadCart() {
        this.setState({ loading: true });
        axios.get("/admin/cart").then((res) => {
            this.setState({ cart: Array.isArray(res.data) ? res.data : [], loading: false });
        }).catch(() => this.setState({ cart: [], loading: false }));
    }

    // ─── EVENT HANDLERS ───────────────────────────────────
    handleOnChangeBarcode(e) {
        this.setState({ barcode: e.target.value });
    }

    handleScanBarcode(e) {
        e.preventDefault();
        const { barcode } = this.state;
        if (!barcode.trim()) return;

        axios.post("/admin/cart", { barcode })
            .then(() => {
                this.loadCart();
                this.setState({ barcode: "" });
            })
            .catch((err) => {
                Swal.fire("Lỗi!", err.response?.data?.message || "Không thể thêm sản phẩm", "error");
            });
    }

    handleChangeQty(product_id, qty) {
        const newQty = parseInt(qty) || 0;
        if (newQty < 0) return;

        // Optimistic update
        this.setState((prev) => ({
            cart: prev.cart.map((item) =>
                item.id === product_id ? { ...item, pivot: { ...item.pivot, quantity: newQty } } : item
            ),
        }));

        if (newQty === 0) return;

        axios.post("/admin/cart/change-qty", { product_id, quantity: newQty })
            .catch((err) => {
                Swal.fire("Lỗi!", err.response?.data?.message || "Cập nhật số lượng thất bại", "error");
                this.loadCart(); // rollback
            });
    }

    handleClickDelete(product_id) {
        axios.post("/admin/cart/delete", { product_id, _method: "DELETE" })
            .then(() => this.loadCart())
            .catch((err) => Swal.fire("Lỗi!", err.response?.data?.message, "error"));
    }

    handleEmptyCart() {
        Swal.fire({
            title: "Xóa toàn bộ giỏ hàng?",
            text: "Hành động này không thể hoàn tác!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Xóa hết",
            cancelButtonText: "Hủy",
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post("/admin/cart/empty", { _method: "DELETE" })
                    .then(() => this.setState({ cart: [] }))
                    .catch(() => Swal.fire("Lỗi!", "Không thể xóa giỏ hàng", "error"));
            }
        });
    }

    handleChangeSearch(e) {
        const value = e.target.value;
        this.setState({ search: value });
        if (e.key === "Enter") {
            this.loadProducts(value);
        }
    }

    addProductToCart(barcode) {
        let product = this.state.products.find((p) => p.barcode === barcode);
        if (!!product) {
            // if product is already in cart
            let cart = this.state.cart.find((c) => c.id === product.id);
            if (!!cart) {
                // update quantity
                this.setState({
                    cart: this.state.cart.map((c) => {
                        if (
                            c.id === product.id &&
                            product.quantity > c.pivot.quantity
                        ) {
                            c.pivot.quantity = c.pivot.quantity + 1;
                        }
                        return c;
                    }),
                });
            } else {
                if (product.quantity > 0) {
                    product = {
                        ...product,
                        pivot: {
                            quantity: 1,
                            product_id: product.id,
                            user_id: 1,
                        },
                    };

                    this.setState({ cart: [...this.state.cart, product] });
                }
            }

            axios
                .post("/admin/cart", { barcode })
                .then((res) => {
                    // this.loadCart();
                })
                .catch((err) => {
                    Swal.fire("Error!", err.response.data.message, "error");
                });
        }
    }

    handleSeach(e) {
        if (e.key === "Enter") {
            this.loadProducts(e.target.value);
        }
    }

    setCustomerId(e) {
        this.setState({ customer_id: e.target.value });
    }

    getTotal(cart) {
        return sum(cart.map((c) => c.pivot.quantity * c.price));
    }

    handleClickSubmit() {
        const total = this.getTotal(this.state.cart);
        Swal.fire({
            title: this.state.translations["received_amount"] || "Số tiền nhận",
            input: "number",
            inputValue: total,
            inputAttributes: { min: total, step: "0.01" },
            showCancelButton: true,
            confirmButtonText: this.state.translations["confirm_pay"] || "Xác nhận thanh toán",
            cancelButtonText: this.state.translations["cancel_pay"] || "Hủy",
            showLoaderOnConfirm: true,
            preConfirm: (amount) => {
                if (parseFloat(amount) < parseFloat(total)) {
                    Swal.showValidationMessage("Số tiền nhận phải lớn hơn hoặc bằng tổng tiền!");
                    return false;
                }
                return axios
                    .post("/admin/orders", {
                        customer_id: this.state.customer_id,
                        amount,
                    })
                    .then((res) => res.data)
                    .catch((err) => {
                        Swal.showValidationMessage(err.response?.data?.message || "Lỗi khi tạo đơn hàng");
                    });
            },
        }).then((result) => {
            if (result.value) {
                Swal.fire("Thành công!", "Đã tạo đơn hàng", "success");
                this.loadCart();
            }
        });
    }

    // ─── RENDER ───────────────────────────────────────────
    render() {
        const { cart, products, customers, barcode, search, translations, loading } = this.state;
        const total = this.getTotal(cart);

        return (
            <div className="container-fluid py-3">
                <div className="row g-3">
                    {/* LEFT - CART */}
                    <div className="col-lg-5 col-xl-5">
                        <div className="card shadow-sm border-0 h-100">
                            <div className="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h5 className="mb-0">Giỏ hàng</h5>
                                <small>{cart.length} sản phẩm</small>
                            </div>

                            <div className="card-body p-3 d-flex flex-column">
                                {/* Barcode + Customer */}
                                <div className="row g-2 mb-3">
                                    <div className="col-7">
                                        <form onSubmit={this.handleScanBarcode}>
                                            <input
                                                type="text"
                                                className="form-control form-control-lg"
                                                placeholder={translations["scan_barcode"] || "Quét mã vạch..."}
                                                value={barcode}
                                                onChange={this.handleOnChangeBarcode}
                                                autoFocus
                                            />
                                        </form>
                                    </div>
                                    <div className="col-5">
                                        <select
                                            className="form-select form-select-xl"
                                            onChange={this.setCustomerId}
                                            value={this.state.customer_id}
                                        >
                                            <option value="">{translations["general_customer"] || "Khách lẻ"}</option>
                                            {customers.map((cus) => (
                                                <option key={cus.id} value={cus.id}>
                                                    {cus.first_name} {cus.last_name}
                                                </option>
                                            ))}
                                        </select>
                                    </div>
                                </div>

                                {/* Cart Items */}
                                <div className="flex-grow-1 overflow-auto" style={{ maxHeight: "55vh" }}>
                                    {loading ? (
                                        <div className="text-center py-5">
                                            <div className="spinner-border text-primary" role="status" />
                                        </div>
                                    ) : cart.length === 0 ? (
                                        <div className="text-center text-muted py-5">
                                            <i className="fas fa-shopping-cart fa-3x mb-3"></i>
                                            <p>Giỏ hàng trống</p>
                                        </div>
                                    ) : (
                                        <div className="list-group list-group-flush">
                                            {cart.map((item) => (
                                                <div
                                                    key={item.id}
                                                    className="list-group-item list-group-item-action px-0 py-3"
                                                >
                                                    <div className="d-flex justify-content-between align-items-center">
                                                        <div className="flex-grow-1">
                                                            <h6 className="mb-1">{item.name}</h6>
                                                            <div className="text-muted small">
                                                                {window.APP.currency_symbol} {item.price}
                                                            </div>
                                                        </div>

                                                        <div className="d-flex align-items-center gap-2">
                                                            <div className="input-group input-group-sm" style={{ width: "120px" }}>
                                                                <button
                                                                    className="btn btn-outline-secondary"
                                                                    onClick={() => this.handleChangeQty(item.id, item.pivot.quantity - 1)}
                                                                >
                                                                    -
                                                                </button>
                                                                <input
                                                                    type="text"
                                                                    className="form-control text-center"
                                                                    value={item.pivot.quantity}
                                                                    onChange={(e) => this.handleChangeQty(item.id, e.target.value)}
                                                                />
                                                                <button
                                                                    className="btn btn-outline-secondary"
                                                                    onClick={() => this.handleChangeQty(item.id, item.pivot.quantity + 1)}
                                                                >
                                                                    +
                                                                </button>
                                                            </div>

                                                            <button
                                                                className="btn btn-sm btn-danger"
                                                                onClick={() => this.handleClickDelete(item.id)}
                                                            >
                                                                <i className="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div className="text-end mt-1 fw-bold">
                                                        {window.APP.currency_symbol} {(item.price * item.pivot.quantity)}
                                                    </div>
                                                </div>
                                            ))}
                                        </div>
                                    )}
                                </div>

                                {/* Total & Actions */}
                                <div className="mt-3 pt-3 border-top">
                                    <div className="d-flex justify-content-between align-items-center mb-3">
                                        <h5 className="mb-0">Tổng tiền:</h5>
                                        <h4 className="mb-0 text-primary fw-bold">
                                            {window.APP.currency_symbol} {total}
                                        </h4>
                                    </div>

                                    <div className="d-grid gap-2 d-flex justify-content-between align-items-center">
                                        <button
                                            className="btn btn-danger btn-lg"
                                            onClick={this.handleEmptyCart}
                                            disabled={!cart.length}
                                        >
                                            {translations["cancel"] || "Hủy đơn"}
                                        </button>
                                        <button
                                            className="btn btn-success btn-lg"
                                            onClick={this.handleClickSubmit}
                                            disabled={!cart.length}
                                        >
                                            <i className="fas fa-check me-2"></i>
                                            {translations["checkout"] || "Thanh toán"}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* RIGHT - PRODUCTS */}
                    <div className="col-lg-7 col-xl-7">
                        <div className="card shadow-sm border-0">
                            <div className="card-header bg-light">
                                <input
                                    type="text"
                                    className="form-control form-control-lg"
                                    placeholder={translations["search_product"] || "Tìm sản phẩm... (Enter để tìm)"}
                                    value={search}
                                    onChange={this.handleChangeSearch}
                                    onKeyDown={this.handleSeach}
                                />
                            </div>

                            <div className="card-body p-3">
                                <div className="row g-3 product-grid">
                                    {products.length === 0 ? (
                                        <div className="col-12 text-center py-5 text-muted">
                                            Không tìm thấy sản phẩm
                                        </div>
                                    ) : (
                                        products.map((p) => (
                                            <div className="col-6 col-md-4 col-lg-3" key={p.id}>
                                                <div
                                                    className="card product-card h-100 shadow-sm border-0 hover-lift"
                                                    onClick={() => this.addProductToCart(p.barcode)}
                                                    role="button"
                                                >
                                                    <img
                                                        src={p.image_url || "https://via.placeholder.com/300x300?text=No+Image"}
                                                        className="card-img-top"
                                                        alt={p.name}
                                                        style={{ height: "160px", objectFit: "cover" }}
                                                    />
                                                    <div className="flex-column card-body d-block p-3">
                                                        <h6 className="text-bold mb-2">
                                                            {p.name}
                                                        </h6>
                                                        <div className="text-muted mb-1 small">
                                                            SL: <strong>{p.quantity}</strong>
                                                        </div>
                                                        {window.APP.warning_quantity > p.quantity && (
                                                            <span className="badge bg-danger">Sắp hết hàng</span>
                                                        )}
                                                        <div className="fw-bold text-primary mt-2">
                                                            {window.APP.currency_symbol} {p.price}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        ))
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* CSS cần thêm vào file css hoặc style tag */}
                <style>{`
          .product-card {
            transition: all 0.2s;
            cursor: pointer;
          }
          .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.12) !important;
          }
          .hover-lift:hover {
            transform: translateY(-3px);
          }
          .product-grid {
            max-height: 75vh;
            overflow-y: auto;
            padding-right: 8px;
          }
        `}</style>
            </div>
        );
    }
}

export default Cart;

const root = document.getElementById("cart");
if (root) {
    createRoot(root).render(<Cart />);
}