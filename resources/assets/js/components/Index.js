import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import Pagination from "react-js-pagination";
import cloneDeep from 'lodash/cloneDeep';
import 'bootstrap/dist/css/bootstrap.min.css';
import Edit from './Edit'

export default class Index extends Component {
    constructor() {
        super();
        this.state = {
            userArr: [],
            search:
                {
                    searchName: '',
                    select: "name",
                    sortBy: "ASC",
                    more_than: '',
                    less_than: '',
                },
            searchName: "",
            timer: '',
        };

        this.handleChange = this.handleChange.bind(this)
        this.saveUser = this.saveUser.bind(this)
        this.editUser = this.editUser.bind(this)
    }

    componentWillMount() {
        axios.get('/api/custom').then(response => {
            this.setState({
                userArr: response.data,
            });
        }).catch(errors => {
            console.log(errors)
        });
    }

    handleChange(event, userObj) {
        let userArr = this.state.userArr;
        userObj[event.target.name] = event.target.value;
        userArr.map(model => {
            if (model.id == userObj.id) {
                model = userObj;
            }
        });
        this.setState({
            userArr: userArr
        });
    }

    editUser(userObj) {
        let userArr = this.state.userArr;
        userObj.editable = true;
        userArr.map(model => {
            if (model.id == userObj.id) {
                model = userObj;
            }
        })
        this.setState({
            userArr: userArr
        })
    }


    saveUser(userObj) {
        let userArr = this.state.userArr;
        userArr.map(model => {
            if (model.id == userObj.id) {
                axios.post('/user/update', {
                    data: model,
                }).then(response => {
                    if (!$.isEmptyObject(response.data.errors)) {
                        model.errors = response.data.errors
                    }
                    else {
                        model.editable = false;
                        model.errors = '';
                    }
                    this.setState({
                        userArr: userArr,
                    })
                })
            }

        })


    }

    handleSearch(event) {
        clearTimeout(this.state.timer)
        let $this = this;
        let search_param = this.state.search
        search_param[event.target.name] = event.target.value
        this.setState({
            search: search_param,
            timer: setTimeout(function () {
                $this.searchUsers()
            }, 500)
        })
    }

    searchUsers() {
        axios.get('/api/custom',
            {
                params: {
                    searchName: this.state.search.searchName,
                    select: this.state.search.select,
                    sort: this.state.search.sortBy,
                    more_than: this.state.search.more_than,
                    less_than: this.state.search.less_than
                }
            }).then(response => {
            this.setState({
                userArr: response.data,
            })
        })
    }

    deleteUser(user) {
        var $this = this;
        axios.get('/destroy/' + user.id).then(response => {
            const newState = $this.state.userArr.slice();
            newState.splice(newState.indexOf(user), 1)
            $this.setState({
                userArr: newState
            })
        })
    }

    // handlePageChange(pageNumber) {
    //     axios.get('/api/custom?page=' + pageNumber, {
    //         params: {
    //             searchName: this.state.searchName,
    //             select: this.state.select,
    //             sort: this.state.sortSelect,
    //             more_than: this.state.more_than,
    //             less_than: this.state.less_than
    //         }
    //     }).then(response => {
    //         this.setState({
    //             userArr: response.data.data,
    //             itemsCountPerPage: response.data.per_page,
    //             totalItemsCount: response.data.total,
    //             activePage: response.data.current_page,
    //         })
    //     })
    // }


    // editUser(user) {
    //     let $this = this;
    //     axios.get('/user/edit/' + user.id).then(response => {
    //             let editingUserObj = response.data;
    //             $this.setState({
    //                 editingUserObj: editingUserObj,
    //             })
    //         }
    //     )
    // }
    // updateUser(e) {
    //     e.preventDefault();
    //     var $i = 0;
    //     this.state.userArr.map((userObj) => {
    //             if (userObj.id == this.state.editingUserObj.id) {
    //                 userObj = this.state.editingUserObj;
    //                 return
    //             }
    //         }
    //     )
    //     axios.post('/user/update', {
    //         name: this.state.editingUserObj.name,
    //         email: this.state.editingUserObj.email,
    //         id: this.state.editingUserObj.id
    //
    //     })
    //     location.reload()
    // }
    render() {
        return (
            <div>
                <div className="container mt-3 ml-3">
                    <div className="row">
                        <div className="col-3 p-0 mr-2 ml-5 ">
                            <input type="text" className="form-control" name="searchName"
                                   onChange={this.handleSearch.bind(this)} value={this.state.search.searchName}/></div>
                        <select name="select" className="btn btn-info col-2 mr-2"
                                onChange={this.handleSearch.bind(this)} value={this.state.search.select}>
                            <option value="name"> name</option>
                            <option value="email">email</option>

                        </select>
                        <div className="btn-group btn-group-toggle mr-2">
                            <label className="btn btn-dark ">

                                <input type="radio" name="sortBy" id="asc" value="ASC"
                                       checked={this.state.search.sortBy === "ASC"}
                                       onChange={this.handleSearch.bind(this)}/> ASC
                            </label>
                            <label className="btn btn-danger ">
                                <input type="radio" name="sortBy" id="desc" value="DESC"
                                       checked={this.state.search.sortBy === "DESC"}
                                       onChange={this.handleSearch.bind(this)}/> DESC
                            </label>
                        </div>
                        <span className=" col-1 btn-success  btn-group-vertical p-0"> <p
                            className="m-auto">More than</p></span>
                        <div className="col-1 p-0 ">
                            <input type="text" className="form-control" id="moreThan" name="more_than"
                                   onChange={this.handleSearch.bind(this)} value={this.state.search.more_than}/>
                        </div>
                        <span className=" col-1 btn-success  btn-group-vertical text-md-center p-0"><p
                            className="m-auto">Less than</p></span>
                        <div className="col-1 p-0 mr-2">
                            <input type="text" className="form-control" id="lessThan" name="less_than"
                                   onChange={this.handleSearch.bind(this)} value={this.state.search.less_than}/>
                        </div>

                    </div>
                </div>
                <div className="conatainer mt-4">
                    <table className="table table-bordered table-hover ">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Projects</th>
                            <th>Tasks</th>
                            <th>Edit</th>
                            <th colSpan="2">Delate</th>
                        </tr>
                        </thead>
                        <tbody>
                        {/*@foreach($userArr as $userObj)*/}

                        {this.state.userArr.map((userObj, i) => (
                                <tr key={i}>
                                    <td>{userObj.id}</td>
                                    <td>

                                        {userObj.editable == true ?
                                            <input className='form-control' type='text'
                                                   onChange={(event) => {
                                                       this.handleChange(event, userObj)
                                                   }} name="name"
                                                   value={userObj.name}/>
                                            : <p>{userObj.name}</p>}

                                        <p className="text-danger">{!$.isEmptyObject(userObj.errors) ? userObj.errors['name'] : ""}</p>
                                    </td>

                                    <td>
                                        {userObj.editable == true ?
                                            <input className='form-control' type='text'
                                                   onChange={(event) => {
                                                       this.handleChange(event, userObj)
                                                   }}
                                                   name="email" value={userObj.email}/>
                                            : <p>{userObj.email}</p>
                                        }
                                        <p className="text-danger">{!$.isEmptyObject(userObj.errors) ? userObj.errors['email'] : ''}</p>
                                    </td>
                                    <td>
                                        {userObj.projects.length}
                                    </td>
                                    <td>{userObj.tasks.length}
                                    </td>
                                    <td>
                                        <Edit userObj={userObj} handleSubmit={this.saveUser} handleSubmit2={this.editUser}/>
                                        {/*{userObj.editable == true ?*/}
                                        {/*<button type="button"*/}
                                        {/*className="btn btn-success"*/}
                                        {/*onClick={this.saveUser.bind(this, userObj)}*/}
                                        {/*>Save</button>*/}

                                        {/*: <button type="button"*/}
                                        {/*className="btn btn-warning"*/}
                                        {/*onClick={this.editUser.bind(this, userObj)}*/}
                                        {/*>Edit</button>*/}
                                        {/*}*/}
                                    </td>

                                    <td>
                                        <button className="btn btn-danger"
                                                onClick={this.deleteUser.bind(this, userObj)}
                                                type="button">Delete
                                        </button>


                                    </td>
                                </tr>

                            )
                        )}
                        </tbody>
                    </table>
                </div>
                {/*<div className="d-flex justify-content-center">*/}
                {/*<Pagination*/}
                {/*activePage={this.state.activePage}*/}
                {/*itemsCountPerPage={this.state.itemsCountPerPage}*/}
                {/*totalItemsCount={this.state.totalItemsCount}*/}
                {/*pageRangeDisplayed={this.state.pageRangeDisplayed}*/}
                {/*onChange={this.handlePageChange}*/}
                {/*itemClass='page-item'*/}
                {/*linkClass='page-link'*/}
                {/*/>*/}
                {/*</div>*/}


            </div>
        );

    }
}
ReactDOM.render(<Index/>, document.getElementById('listPage'));

