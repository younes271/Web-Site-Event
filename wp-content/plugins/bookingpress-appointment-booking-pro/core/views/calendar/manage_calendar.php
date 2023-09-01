<?php 
	global $bookingpress_ajaxurl, $bookingpress_common_date_format, $BookingPressPro, $bookingpress_global_options;
	$bookingpress_common_datetime_format = $bookingpress_common_date_format . ' HH:mm';
	$bookingpress_global_options_arr = $bookingpress_global_options->bookingpress_global_options();
	$bookingpress_singular_staffmember_name = !empty($bookingpress_global_options_arr['bookingpress_staffmember_singular_name']) ? $bookingpress_global_options_arr['bookingpress_staffmember_singular_name'] : esc_html_e('Staff Member', 'bookingpress-appointment-booking');
	$bookingpress_plural_staffmember_name = !empty($bookingpress_global_options_arr['bookingpress_staffmember_plural_name']) ? $bookingpress_global_options_arr['bookingpress_staffmember_plural_name'] : esc_html_e('Staff Members', 'bookingpress-appointment-booking');
?>
<el-main class="bpa-main-listing-card-container bpa-default-card bpa--is-page-scrollable-tablet" :class="(bookingpress_staff_customize_view == 1 ) ? 'bpa-main-list-card__is-staff-custom-view':''" id="all-page-main-container">
<?php if ( current_user_can('administrator') ) { ?>
	<div class="bpa-unlicense-warning-belt" v-if="typeof is_licence_activated != 'undefined' && is_licence_activated != ''">		
		<span class="material-icons-round">info</span>
		<P v-html="is_licence_activated"></P> 
		<span class="bpa-uwb-close-icon material-icons-round" @click="bookingpress_close_licence_notice">close</span>
	</div> <?php } ?>
	<el-row type="flex" class="bpa-mlc-head-wrap">
		<el-col :xs="12" :sm="12" :md="12" :lg="12" :xl="12" class="bpa-mlc-left-heading">
			<h1 class="bpa-page-heading"><?php esc_html_e( 'Calendar', 'bookingpress-appointment-booking' ); ?></h1>
		</el-col>
		<el-col :xs="12" :sm="12" :md="12" :lg="12" :xl="12">
			<div class="bpa-hw-right-btn-group">
				<?php
				if ( $BookingPressPro->bookingpress_check_capability( 'bookingpress_edit_appointments' ) ) {
					?>
				<el-button class="bpa-btn bpa-btn--primary" @click="openAppointmentBookingModal"> 
					<span class="material-icons-round">add</span> 
					<?php esc_html_e( 'Add Appointment', 'bookingpress-appointment-booking' ); ?>
				</el-button>
				<?php } ?>
				<el-button class="bpa-btn" @click="openNeedHelper('list_calendar', 'calendar', 'Calendar')">
					<span class="material-icons-round">help</span>
					<?php esc_html_e( 'Need help?', 'bookingpress-appointment-booking' ); ?>
				</el-button>
				<el-button class="bpa-btn" @click="open_feature_request_url">
					<span class="material-icons-round">lightbulb</span>
					<?php esc_html_e( 'Feature Requests', 'bookingpress-appointment-booking' ); ?>
				</el-button>
			</div>
		</el-col>
	</el-row>
	<div class="bpa-back-loader-container" id="bpa-page-loading-loader">
			<div class="bpa-back-loader"></div>
	</div>
	<div id="bpa-main-container">
		<el-row>
			<div class="bpa-table-filter">
				<el-row type="flex" :gutter="32">
					<el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="6">
						<span class="bpa-form-label"><?php esc_html_e( 'Service', 'bookingpress-appointment-booking' ); ?></span>
						<el-select v-model="search_data.selected_services" class="bpa-form-control" multiple filterable collapse-tags 
							placeholder="<?php esc_html_e( 'Select Service', 'bookingpress-appointment-booking' ); ?>"
							:popper-append-to-body="false" popper-class="bpa-el-select--is-with-navbar bpa-el-select--cal-service-dropdown">		
							<el-option-group v-for="item in appointment_services_data" :key="item.category_name" :label="item.category_name">
								<el-option v-for="cat_services in item.category_services" :key="cat_services.service_id" :label="cat_services.service_name" :value="cat_services.service_id"></el-option>
							</el-option-group>
						</el-select>
					</el-col>						
					<?php if ( ! $BookingPressPro->bookingpress_check_user_role( 'bookingpress-staffmember' ) ) { ?>
					<el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="6" v-if="is_staffmember_activated == 1">
						<span class="bpa-form-label"><?php echo esc_html_e('Select', 'bookingpress-appointment-booking').esc_html(" ".$bookingpress_plural_staffmember_name); ?></span>
						<el-select v-model="search_data.selected_staff_member" class="bpa-form-control" multiple filterable collapse-tags 
							placeholder="<?php echo esc_html( 'Select').esc_html(" ".$bookingpress_plural_staffmember_name); ?>"
							:popper-append-to-body="false" popper-class="bpa-el-select--is-with-navbar">		
							<el-option v-for="item in search_staff_member_list" :key="item.value" :label="item.text" :value="item.value"></el-option>
						</el-select>
					</el-col>
					<?php } ?>
					<el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="6">
						<span class="bpa-form-label"><?php esc_html_e( 'Customers', 'bookingpress-appointment-booking' ); ?></span>						
						<el-select class="bpa-form-control" v-model="search_data.selected_customers" multiple filterable collapse-tags placeholder="<?php esc_html_e( 'Start typing to fetch customer', 'bookingpress-appointment-booking' ); ?>" remote reserve-keyword :remote-method="bookingpress_get_search_customer_list" :loading="bookingpress_loading" :popper-append-to-body="false" popper-class="bpa-el-select--is-with-navbar">
							<el-option v-for="item in search_customer_list" :key="item.value" :label="item.text" :value="item.value"></el-option>
						</el-select>
					</el-col>
					<el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="6">
						<span class="bpa-form-label"><?php esc_html_e( 'Appointment Status', 'bookingpress-appointment-booking' ); ?></span>
						<el-select class="bpa-form-control" v-model="search_data.selected_status" 
							placeholder="<?php esc_html_e( 'Select status', 'bookingpress-appointment-booking' ); ?>"
							:popper-append-to-body="false" popper-class="bpa-el-select--is-with-navbar">
                            <el-option label="<?php esc_html_e('All', 'bookingpress-appointment-booking'); ?>" value="all"></el-option>
							<el-option v-for="item in search_status" :key="item.value" :label="item.text" :value="item.value"></el-option>
						</el-select>
					</el-col>
					<el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="6">
						<div class="bpa-tf-btn-group">
							<el-button class="bpa-btn bpa-btn__medium bpa-btn--full-width" @click="resetFilter">
								<?php esc_html_e( 'Reset', 'bookingpress-appointment-booking' ); ?>
							</el-button>
							<el-button class="bpa-btn bpa-btn__medium bpa-btn--primary bpa-btn--full-width" @click="loadCalendar">
								<?php esc_html_e( 'Apply', 'bookingpress-appointment-booking' ); ?>
							</el-button>
						</div>
					</el-col>
				</el-row>
			</div>
			<el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
				<div class="bpa-full-screen-calendar">
					<div class="bpa-fsc--custom-filter-header">
						<div class="bpa-cfh--wrapper">
							<div class="bpa-cfh__left">
								<el-button class="bpa-btn bpa-btn__medium" @click="$refs.bpavuecal.previous()">
									<span class="material-icons-round">arrow_back_ios</span>
								</el-button>
								<el-button class="bpa-btn bpa-btn__medium" @click="$refs.bpavuecal.next()">
									<span class="material-icons-round">arrow_forward_ios</span>
								</el-button>
							</div>
							<div class="bpa-cfh__right">
								<div class="bpa-cfh__legends">
									<div class="bpa-cfh__legends--item">
										<p><?php esc_html_e( 'Approved', 'bookingpress-appointment-booking' ); ?></p>
									</div>
									<div class="bpa-cfh__legends--item">
										<p><?php esc_html_e( 'Pending', 'bookingpress-appointment-booking' ); ?></p>
									</div>
									<div class="bpa-cfh__legends--item">
										<p><?php esc_html_e( 'Rejected', 'bookingpress-appointment-booking' ); ?></p>
									</div>
								</div>
								<div class="bpa-cfh__btns">
									<div class="bpa-cfh__btns-wrapper">
									<el-button class="bpa-btn bpa-btn__medium" :class="activeView == 'month' ? 'bpa-btn--primary' : ''" @click="activeView = 'month'"><?php esc_html_e( 'Month', 'bookingpress-appointment-booking' ); ?></el-button>
									<el-button class="bpa-btn bpa-btn__medium" :class="activeView == 'week' ? 'bpa-btn--primary' : ''" @click="activeView = 'week'"><?php esc_html_e( 'Week', 'bookingpress-appointment-booking' ); ?></el-button>
									<el-button class="bpa-btn bpa-btn__medium" :class="activeView == 'day' ? 'bpa-btn--primary' : ''" @click="activeView = 'day'"><?php esc_html_e( 'Day', 'bookingpress-appointment-booking' ); ?></el-button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					if ( $BookingPressPro->bookingpress_check_capability( 'bookingpress_edit_appointments' ) ) {
						?>
					<el-row>
						<el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
							<vue-cal ref="bpavuecal" small :time-format="bookingpress_calendar_time_format" :selected-date="calendar_current_date" :time-from="00 * 60" :time-to="25 * 60" :disable-views="['years', 'year']" :events="calendar_events_data" :on-event-click="editEvent" :showAllDayEvents="show_all_day_events" events-on-month-view="true" hide-view-selector :active-view.sync="activeView" :min-event-width="minEventWidth" :locale="site_locale">
								<template v-slot:title="{ title, view }">
									<span v-if="view.id === 'month'">{{ view.startDate.toLocaleString(site_locale, { month: "long" }) }} {{ view.startDate.format('YYYY') }}</span>
									<span v-if="view.id === 'week'"><?php esc_html_e( 'Week', 'bookingpress-appointment-booking' ); ?> {{ view.startDate.getWeek() }} ({{ view.startDate.toLocaleString(site_locale, { month: "long" }) }} {{ view.startDate.format('YYYY') }})</span>
									<span v-if="view.id === 'day'">{{ view.startDate.format('D') }} {{ view.startDate.toLocaleString(site_locale, { month: "long" }) }} {{ view.startDate.format('YYYY') }}</span>
								</template>
								<template v-slot:arrow-prev>
									<span></span>
								</template>
								<template v-slot:arrow-next>
									<span></span>
								</template>
							</vue-cal>
						</el-col>
					</el-row>
					<?php } else { ?>
						<el-row>
							<el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
								<vue-cal ref="bpavuecal" small :time-format="bookingpress_calendar_time_format" :selected-date="calendar_current_date" :time-from="00 * 60" :time-to="25 * 60" :disable-views="['years', 'year']" :events="calendar_events_data" :showAllDayEvents="show_all_day_events" events-on-month-view="true" hide-view-selector :active-view.sync="activeView" :min-event-width="minEventWidth" :locale="site_locale">
									<template v-slot:title="{ title, view }">
										<span v-if="view.id === 'month'">{{ view.startDate.toLocaleString(site_locale, { month: "long" }) }} {{ view.startDate.format('YYYY') }}</span>
										<span v-if="view.id === 'week'"><?php esc_html_e( 'Week', 'bookingpress-appointment-booking' ); ?> {{ view.startDate.getWeek() }} ({{ view.startDate.toLocaleString(site_locale, { month: "long" }) }} {{ view.startDate.format('YYYY') }})</span>
										<span v-if="view.id === 'day'">{{ view.startDate.format('D') }} {{ view.startDate.toLocaleString(site_locale, { month: "long" }) }} {{ view.startDate.format('YYYY') }}</span>
									</template>
									<template v-slot:arrow-prev>
										<span></span>
									</template>
									<template v-slot:arrow-next>
										<span></span>
									</template>
								</vue-cal>
							</el-col>
						</el-row>
						<?php
					}
					?>
				</div>
			</el-col>
		</el-row>
	</div>
</el-main>

<el-dialog custom-class="bpa-dialog bpa-dialog--fullscreen bpa--is-page-scrollable-tablet" modal-append-to-body=false :visible.sync="open_calendar_appointment_modal" :before-close="closeAppointmentBookingModal" fullscreen=true :close-on-press-escape="close_modal_on_esc">
	<div class="bpa-dialog-heading">
		<el-row type="flex">
			<el-col :xs="12" :sm="12" :md="16" :lg="16" :xl="16">
				<h1 class="bpa-page-heading" v-if="appointment_formdata.appointment_update_id == 0"><?php esc_html_e( 'Add Appointment', 'bookingpress-appointment-booking' ); ?></h1>
				<h1 class="bpa-page-heading" v-else><?php esc_html_e( 'Edit Appointment', 'bookingpress-appointment-booking' ); ?></h1>
			</el-col>
			<el-col :xs="12" :sm="12" :md="7" :lg="7" :xl="7" class="bpa-dh__btn-group-col">
				<el-button class="bpa-btn bpa-btn--primary" :class="(is_display_save_loader == '1') ? 'bpa-btn--is-loader' : ''" @click="saveProAppointmentBooking('appointment_formdata')" :disabled="is_disabled" >					
				  <span class="bpa-btn__label"><?php esc_html_e( 'Save', 'bookingpress-appointment-booking' ); ?></span>
				  <div class="bpa-btn--loader__circles">				    
					  <div></div>
					  <div></div>
					  <div></div>
				  </div>
				</el-button>
                <el-button class="bpa-btn" @click="closeAppointmentBookingModal"><?php esc_html_e('Cancel', 'bookingpress-appointment-booking'); ?></el-button>
			</el-col>
		</el-row>
	</div>
	<div class="bpa-dialog-body">
		<div class="bpa-form-row">
			<el-row>
				<el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
					<div class="bpa-db-sec-heading">
						<el-row type="flex" align="middle">
							<el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
								<div class="db-sec-left">
									<h2 class="bpa-page-heading"><?php esc_html_e( 'Basic Details', 'bookingpress-appointment-booking' ); ?></h2>
								</div>
							</el-col>							
							<el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
								<div class="bpa-hw-right-btn-group">
									<el-button class="bpa-btn bpa-btn--icon-without-box __is-label" @click="openNeedHelper('list_appointments', 'appointments', 'Appointments')">
										<span class="material-icons-round">help</span>
										<?php esc_html_e( 'Need help?', 'bookingpress-appointment-booking' ); ?>
									</el-button>
								</div>
							</el-col>
						</el-row>
					</div>
					<div class="bpa-default-card bpa-db-card">
						<el-form class="bpa-add-appointment-form" ref="appointment_formdata" :rules="rules" :model="appointment_formdata" label-position="top" @submit.native.prevent>
							<template>								
								<div class="bpa-form-body-row">
									<el-row :gutter="32">
										<el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8" :class="(is_extras_enable == 1) ? 'bpa-select-appointment-service' : ''">
											<el-form-item prop="appointment_selected_service">
												<template #label>
													<span class="bpa-form-label"><?php esc_html_e( 'Select Service', 'bookingpress-appointment-booking' ); ?></span>
												</template>
												<div class="bpa-aaf__service-selection-col">
													<el-select class="bpa-form-control" @Change="bookingpress_appointment_change_service" v-model="appointment_formdata.appointment_selected_service" name="appointment_selected_service" filterable placeholder="<?php esc_html_e( 'Select Service', 'bookingpress-appointment-booking' ); ?>" popper-class="bpa-el-select--is-with-modal">
														<el-option-group v-for="service_cat_data in appointment_services_list" :key="service_cat_data.category_name" :label="service_cat_data.category_name">
															<template v-if="service_data.service_id == 0" v-for="service_data in service_cat_data.category_services">
																<el-option :key="service_data.service_id" :label="service_data.service_name" :value="''" ></el-option>
															</template>
															<template v-else>
																<el-option :key="service_data.service_id" :label="service_data.service_name+' ('+service_data.service_price+' )'" :value="service_data.service_id"></el-option>
															</template>
														</el-option-group>
													</el-select>
													<el-popover width="400" trigger="click" popper-class="bpa-aaf--extra-popover" v-modal="bookingpress_extras_popover_modal" v-if="is_extras_enable == 1" :disabled="(appointment_formdata.appointment_selected_service == '' || bookingpress_loaded_extras[appointment_formdata.appointment_selected_service].length == 0) ? true : false">
														<div class="bpa-aaf--service-extras">
															<h4><?php esc_html_e('Select Extras', 'bookingpress-appointment-booking'); ?></h4>
															<div class="bpa-aaf__extras-body" v-if="appointment_formdata.appointment_selected_service != ''">
																<div class="bpa-aaf-extra__item" v-for="(extras_details, index) in bookingpress_loaded_extras[appointment_formdata.appointment_selected_service]" v-if="bookingpress_loaded_extras[appointment_formdata.appointment_selected_service].length > 0">
																	<div class="bpa-aaf-ei__header">
																		<div class="bpa-aaf-ei__left">
																			<div class="bpa-aaf-ei__left-checkbox">
																				<el-checkbox class="bpa-form-control--checkbox" v-model="bookingpress_loaded_extras[appointment_formdata.appointment_selected_service][index]['bookingpress_is_selected']"></el-checkbox>
																			</div>
																			<div class="bpa-aaf-ei__left-body">
																				<h5 class="bpa-aaf-ei__heading">{{ extras_details.bookingpress_extra_service_name }}</h5>
																				<div class="bpa-aaf-ei--options">
																					<p>{{ extras_details.bookingpress_extra_service_price_with_currency }}</p>
																					<p class="bpa-aaf-ei__duration"><span class="material-icons-round">schedule</span> {{ extras_details.bookingpress_extra_service_duration }}{{ extras_details.bookingpress_extra_service_duration_unit }}</p>
																				</div>
																				<div class="bpa-aaf-ei__description" v-if="extras_details.bookingpress_service_description != ''">																					
																					<el-link class="bpa-aaf-ei__btn" @click="bookingpress_toggle_extra_address(extras_details.bookingpress_extra_services_id, 1)" v-if="extras_details.bookingpress_is_display_description == '0'">
																						<?php esc_html_e('View more', 'bookingpress-appointment-booking'); ?> 
																						<span class="material-icons-round">add</span>
																					</el-link>
																					<el-link class="bpa-aaf-ei__btn" @click="bookingpress_toggle_extra_address(extras_details.bookingpress_extra_services_id, 0)" v-if="extras_details.bookingpress_is_display_description == '1'">
																						<?php esc_html_e('View less', 'bookingpress-appointment-booking'); ?> 
																						<span class="material-icons-round">remove</span>
																					</el-link>
																					<p v-if="extras_details.bookingpress_is_display_description == '1'">{{ extras_details.bookingpress_service_description }}</span>
																				</div>
																			</div>
																		</div>
																		<div class="bpa-aaf-ei__right">
																			<el-select class="bpa-form-control" popper-class="bpa-aaf-ei-quantity-dropdown bpa-sum-ei-quantity-dropdown" v-model="bookingpress_loaded_extras[appointment_formdata.appointment_selected_service][index]['bookingpress_selected_qty']">
																				<el-option v-for="n in parseInt(extras_details.bookingpress_extra_service_max_quantity)" :value="n">{{ n }}</el-option>
																			</el-select>
																		</div>
																	</div>
																</div>

															</div>
															<div class="bpa-aaf__extras-foot">
																<el-button class="bpa-btn bpa-btn__small" @click="bookingpress_close_extras_modal"><?php esc_html_e('Cancel', 'bookingpress-appointment-booking'); ?></el-button>
																<el-button class="bpa-btn bpa-btn--primary bpa-btn__small" @click="bookingpress_add_extras"><?php esc_html_e('Add', 'bookingpress-appointment-booking'); ?></el-button>
															</div>
														</div>
														<el-button slot="reference" class="bpa-btn bpa-btn__medium" :class="(appointment_formdata.appointment_selected_service == '' || bookingpress_loaded_extras[appointment_formdata.appointment_selected_service].length == 0) ? '__bpa-is-disabled' : ''">
															<?php esc_html_e('Add Extra', 'bookingpress-appointment-booking'); ?>
															<span class="bpa-ep__counter" v-if="appointment_formdata.selected_extra_services_ids.length > 0">{{ appointment_formdata.selected_extra_services_ids.length }}</span>
														</el-button>
													</el-popover>
												</div>
												<div class="bpa-aaf__extras-preview" v-if="appointment_formdata.selected_extra_services_ids.length > 0">
													<h4><?php esc_html_e('Extras', 'bookingpress-appointment-booking'); ?></h4>
													<div class="bpa-aaf-ep__items">
														<div class="bpa-aaf-ep__item" v-for="selected_extras in bookingpress_loaded_extras[appointment_formdata.appointment_selected_service]" v-if="selected_extras.bookingpress_is_selected === true">
															<p v-if="selected_extras.bookingpress_is_selected === true">{{ selected_extras.bookingpress_extra_service_name }}</p>
															<span class="material-icons-round" @click="bookingpress_remove_extras(selected_extras.bookingpress_extra_services_id)">close</span>
														</div>
													</div>
												</div>
											</el-form-item>
										</el-col>
										<el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8" v-if="is_staff_enable == 1">
											<el-form-item>
												<template #label>
													<span class="bpa-form-label"><?php echo esc_html__('Select', 'bookingpress-appointment-booking')." ".esc_html($bookingpress_singular_staffmember_name); ?></span>
												</template>
												<el-select class="bpa-form-control" placeholder="<?php esc_html_e('Select', 'bookingpress-appointment-booking'); ?><?php echo " ".esc_html($bookingpress_singular_staffmember_name); ?>" filterable v-model="appointment_formdata.selected_staffmember" @change="bookingpress_change_staff" >
													<el-option value=""><?php esc_html_e('Select', 'bookingpress-appointment-booking'); ?><?php echo " ".esc_html($bookingpress_singular_staffmember_name); ?></el-option>
													<el-option :label="staff_member_details.profile_details.bookingpress_staffmember_firstname != '' && staff_member_details.profile_details.bookingpress_staffmember_lastname != '' ? staff_member_details.profile_details.bookingpress_staffmember_firstname+' '+staff_member_details.profile_details.bookingpress_staffmember_lastname+' ( '+staff_member_details.staff_price_with_currency+' )' : staff_member_details.profile_details.bookingpress_staffmember_email+' ( '+staff_member_details.staff_price_with_currency+' )'" :value="staff_member_details.profile_details.bookingpress_staffmember_id" v-for="staff_member_details in bookingpress_loaded_staff[appointment_formdata.appointment_selected_service]" v-if="typeof staff_member_details.profile_details != 'undefined'"></el-option>
												</el-select>
											</el-form-item>
										</el-col>
										<el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8" v-if="is_bring_anyone_with_you_enable == 1">
											<el-form-item>
												<template #label>
													<span class="bpa-form-label"><?php esc_html_e( 'No. of Person', 'bookingpress-appointment-booking' ); ?></span>
												</template>
												<el-input-number v-model="appointment_formdata.selected_bring_members" class="bpa-form-control bpa-form-control--number" :min="1" :max="appointment_formdata.bookingpress_bring_anyone_max_capacity" @change="bookingpress_change_bring_anyone()" step-strictly></el-input-number>
											</el-form-item> 
										</el-col>
										<?php do_action('bookingpress_add_appointment_custom_service_duration_field_section') ?>
									</el-row>
									<el-row :gutter="32">
										<el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8">
											<el-form-item prop="appointment_booked_date">
												<template #label>
													<span class="bpa-form-label"><?php esc_html_e( 'Appointment Date', 'bookingpress-appointment-booking' ); ?></span>
												</template>
												<el-date-picker class="bpa-form-control bpa-form-control--date-picker" format="<?php echo esc_html( $bookingpress_common_date_format ); ?>" v-model="appointment_formdata.appointment_booked_date" name="appointment_booked_date" type="date" :clearable="false" :picker-options="pickerOptions" @change="select_appointment_booking_date($event)" popper-class="bpa-el-select--is-with-modal bpa-el-datepicker-widget-wrapper" value-format="yyyy-MM-dd"></el-date-picker>
											</el-form-item>
										</el-col>
										<el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8" v-show="is_timeslot_display == '1'">
											<el-form-item prop="appointment_booked_time">
												<template #label>
													<span class="bpa-form-label"><?php esc_html_e( 'Appointment Time', 'bookingpress-appointment-booking' ); ?></span>
												</template>
												<el-select class="bpa-form-control" Placeholder="<?php esc_html_e( 'Select Time', 'bookingpress-appointment-booking' ); ?>" v-model="appointment_formdata.appointment_booked_time" filterable popper-class="bpa-el-select--is-with-modal" @Change="bookingpress_set_time($event,appointment_time_slot)">
													<el-option-group v-for="appointment_time_slot_data in appointment_time_slot" :key="appointment_time_slot_data.timeslot_label" :label="appointment_time_slot_data.timeslot_label">
														<el-option v-for="appointment_time in appointment_time_slot_data.timeslots" :label="(appointment_time.formatted_start_time)+' to '+(appointment_time.formatted_end_time)" :value="appointment_time.store_start_time" :disabled="( appointment_time.is_disabled || appointment_time.max_capacity == 0 || appointment_time.is_booked == 1 )">
														<span>{{ appointment_time.formatted_start_time  }} to {{appointment_time.formatted_end_time}}</span>
														</el-option>	
													</el-option-group>
												</el-select>
											</el-form-item>
										</el-col>
										<el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8">
											<el-form-item>
											<template #label>
												<span class="bpa-form-label"><?php esc_html_e( 'Select Status', 'bookingpress-appointment-booking' ); ?></span>
											</template>
                                            <el-select class="bpa-form-control" v-model="appointment_formdata.appointment_status" popper-class="bpa-el-select--is-with-modal">
												<el-option v-for="status_data in appointment_status" :key="status_data.value" :label="status_data.text" :value="status_data.value">
													<span>{{ status_data.text }}</span>
												</el-option>
											</el-select>
											</el-form-item>
										</el-col>
									</el-row>
									<el-row :gutter="32">
										<el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8">											
											<el-form-item prop="appointment_selected_customer">
												<template #label>
													<span class="bpa-form-label"><?php esc_html_e( 'Select Customer', 'bookingpress-appointment-booking' ); ?></span>
												</template>
												<el-select class="bpa-form-control" name="appointment_selected_customer" @change="bookingpress_select_customer($event)" v-model="appointment_formdata.appointment_selected_customer" filterable placeholder="<?php esc_html_e( 'Start typing to fetch Customer', 'bookingpress-appointment-booking' ); ?>" remote reserve-keyword :remote-method="bookingpress_get_customer_list" :loading="bookingpress_loading"  popper-class="bpa-el-select--is-with-modal">
												<?php
												if ( $BookingPressPro->bookingpress_check_capability( 'bookingpress_edit_customers' ) ) {
												?>
													<el-option value="add_new" label="Add New">
														<i class="el-icon-plus" ></i>
														<span><?php esc_html_e( 'Add New', 'bookingpress-appointment-booking' ); ?></span>
													</el-option>
												<?php
												}
												?>
													<el-option v-for="customer_data in appointment_customers_list" :key="customer_data.value" :label="customer_data.text" :value="customer_data.value">
														<span>{{ customer_data.text }}</span>
													</el-option>
                                                </el-select>  															
											</el-form-item>
										</el-col>
										<el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8">
											<el-form-item>
												<template #label>
													<span class="bpa-form-label"><?php esc_html_e( 'Internal note', 'bookingpress-appointment-booking' ); ?></span>
												</template>
												<el-input class="bpa-form-control" v-model="appointment_formdata.appointment_internal_note"></el-input>
											</el-form-item>
										</el-col>
									</el-row>
								</div>						
								<div class="bpa-form-body-row">
									<el-row :gutter="24">
										<el-col :xs="24" :sm="24" :md="24" :lg="08" :xl="08">
											<el-form-item>
												<label class="bpa-form-label bpa-custom-checkbox--is-label"> <el-checkbox v-model="appointment_formdata.appointment_send_notification"></el-checkbox> <?php esc_html_e( 'Do Not Send Notifications', 'bookingpress-appointment-booking' ); ?></label>
											</el-form-item>
										</el-col> 										
										<?php do_action('bookingpress_add_appointment_field_section') ?>
									</el-row>
								</div>	
							</template>
						</el-form>
					</div>
				</el-col>				
			</el-row>			
		</div>
		<div class="bpa-form-row">
			<el-row>
				<el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24" v-if="bookingpress_form_fields.length > 0">
					<div class="bpa-db-sec-heading">
						<el-row type="flex" align="middle">
							<el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
								<div class="db-sec-left">
									<h2 class="bpa-page-heading"><?php esc_html_e( 'Custom Fields', 'bookingpress-appointment-booking' ); ?></h2>
								</div>
							</el-col>
						</el-row>
					</div>
					<div class="bpa-default-card bpa-db-card">
						<el-form ref="appointment_custom_formdata" :rules="custom_field_rules" :model="appointment_formdata.bookingpress_appointment_meta_fields_value" label-position="top" @submit.native.prevent>
							<template>
								<div class="bpa-form-body-row">
									<el-row :gutter="34">
										<el-col :xs="24" :sm="24" :md="24" :lg="08" :xl="08" v-for="form_fields in bookingpress_form_fields" :class="(form_fields.is_separator == true) ? '--bpa-is-field-separator' : ''">
											<div v-if="form_fields.is_separator == false">
												<div v-if="form_fields.selected_services.length > 0">
													<el-form-item v-if='(form_fields.bookingpress_field_type == "text" || form_fields.bookingpress_field_type == "email" || form_fields.bookingpress_field_type == "phone") && form_fields.selected_services.includes(appointment_formdata.appointment_selected_service)' :prop="form_fields.bookingpress_field_meta_key">
														<template #label>
															<span class="bpa-form-label">{{ form_fields.bookingpress_field_label }}</span>
														</template>
														<el-input class="bpa-form-control" v-model="appointment_formdata.bookingpress_appointment_meta_fields_value[form_fields.bookingpress_field_meta_key]" :placeholder="form_fields.bookingpress_field_placeholder"></el-input>
													</el-form-item>
													<el-form-item v-if='form_fields.bookingpress_field_type == "textarea" && form_fields.selected_services.includes(appointment_formdata.appointment_selected_service)' :prop="form_fields.bookingpress_field_meta_key">
														<template #label>
															<span class="bpa-form-label">{{ form_fields.bookingpress_field_label }}</span>
														</template>
														<el-input class="bpa-form-control" v-model="appointment_formdata.bookingpress_appointment_meta_fields_value[form_fields.bookingpress_field_meta_key]" :placeholder="form_fields.bookingpress_field_placeholder" type="textarea" :rows="3"></el-input>
													</el-form-item>									
													<el-form-item v-if="form_fields.bookingpress_field_type == 'checkbox' && form_fields.selected_services.includes(appointment_formdata.appointment_selected_service)" :prop="form_fields.bookingpress_field_meta_key">
														<template #label>
															<span class="bpa-form-label">{{ form_fields.bookingpress_field_label }}</span>
														</template>
														<el-checkbox-group v-model="appointment_formdata.bookingpress_appointment_meta_fields_value[form_fields['bookingpress_field_meta_key']]">
															<el-checkbox class="bpa-front-label bpa-custom-checkbox--is-label" v-for="(chk_data, keys) in JSON.parse( form_fields.bookingpress_field_values)" :label="chk_data.value" :key="chk_data.value" :name="form_fields['bookingpress_field_meta_key']"><p v-html="chk_data.label"></p></el-checkbox>
														</el-checkbox-group>
													</el-form-item>
													<el-form-item v-if="form_fields.bookingpress_field_type == 'radio' && form_fields.selected_services.includes(appointment_formdata.appointment_selected_service)" :prop="form_fields.bookingpress_field_meta_key">
														<template #label>
															<span class="bpa-form-label">{{ form_fields.bookingpress_field_label }}</span>
														</template>
														<el-radio class="bpa-form-label bpa-custom-radio--is-label" v-model="appointment_formdata.bookingpress_appointment_meta_fields_value[form_fields.bookingpress_field_meta_key]" v-for="(chk_data, keys) in JSON.parse(form_fields.bookingpress_field_values)" :label="chk_data.label" :key="chk_data.value">{{chk_data.label}}</el-radio>
													</el-form-item>
													<el-form-item v-if='form_fields.bookingpress_field_type == "dropdown" && form_fields.selected_services.includes(appointment_formdata.appointment_selected_service)' :prop="form_fields.bookingpress_field_meta_key">
														<template #label>
															<span class="bpa-form-label">{{ form_fields.bookingpress_field_label }}</span>
														</template>
														<el-select class="bpa-form-control" :placeholder="form_fields.bookingpress_field_placeholder" v-model="appointment_formdata.bookingpress_appointment_meta_fields_value[form_fields.bookingpress_field_meta_key]">
															<el-option v-for="sel_data in JSON.parse(form_fields.bookingpress_field_values)" :key="sel_data.value" :label="sel_data.label" :value="sel_data.value" ></el-option>
														</el-select>
													</el-form-item>
													<el-form-item v-if='form_fields.bookingpress_field_type == "date" && form_fields.selected_services.includes(appointment_formdata.appointment_selected_service)' :prop="form_fields.bookingpress_field_meta_key">
														<template #label>
															<span class="bpa-form-label">{{ form_fields.bookingpress_field_label }}</span>
														</template>
														<el-date-picker :format="( 'true' == form_fields.bookingpress_field_options.enable_timepicker ) ? '<?php echo esc_html( $bookingpress_common_datetime_format ); ?>' : '<?php echo esc_html( $bookingpress_common_date_format ) ?>'" class="bpa-form-control bpa-form-control--date-picker" prefix-icon="" v-model="appointment_formdata.bookingpress_appointment_meta_fields_value[form_fields.bookingpress_field_meta_key]" :placeholder="form_fields.bookingpress_field_placeholder" :type="'true' == form_fields.bookingpress_field_options.enable_timepicker ? 'datetime' : 'date'" :value-format="form_fields.bookingpress_field_options.enable_timepicker == 'true' ? 'yyyy-MM-dd hh:mm:ss' : 'yyyy-MM-dd'" :picker-options="filter_pickerOptions"></el-date-picker> <!-- @change="bookingpress_custom_field_date_change($event,form_fields.bookingpress_field_meta_key,form_fields.bookingpress_field_options.enable_timepicker)" -->
													</el-form-item>
													<el-form-item v-if='form_fields.bookingpress_field_type == "file" && form_fields.selected_services.includes(appointment_formdata.appointment_selected_service)' :prop="form_fields.bookingpress_field_meta_key">
														<template #label>
															<span class="bpa-form-label">{{ form_fields.bookingpress_field_label }}</span>
														</template>
														<el-upload :action="form_fields.bpa_action_url" :ref="form_fields.bpa_ref_name" :data="form_fields.bpa_action_data" v-model="appointment_formdata.bookingpress_appointment_meta_fields_value[form_fields.bookingpress_field_meta_key]" :on-success="BPACustomerFileUpload" :on-remove="BPACustomerFileUploadRemove" :file-list="form_fields.bpa_file_list" :on-error="BPACustomerFileUploadError" multiple="false" limit="1" :name="form_fields.bookingpress_field_meta_key" >
															<label for="bpa-file-upload-two" class="bpa-form-control--file-upload" >
																<span class="bpa-fu__placeholder">Choose a file...</span>
																<span class="bpa-fu__btn">Browse</span>
															</label> 
														</el-upload>
													</el-form-item>
												</div>
												<div v-else>
													<el-form-item v-if='(form_fields.bookingpress_field_type == "text" || form_fields.bookingpress_field_type == "email" || form_fields.bookingpress_field_type == "phone")' :prop="form_fields.bookingpress_field_meta_key">
														<template #label>
															<span class="bpa-form-label">{{ form_fields.bookingpress_field_label }}</span>
														</template>
														<el-input class="bpa-form-control" v-model="appointment_formdata.bookingpress_appointment_meta_fields_value[form_fields.bookingpress_field_meta_key]" :placeholder="form_fields.bookingpress_field_placeholder"></el-input>
													</el-form-item>

													<el-form-item v-if='form_fields.bookingpress_field_type == "textarea"' :prop="form_fields.bookingpress_field_meta_key">
														<template #label>
															<span class="bpa-form-label">{{ form_fields.bookingpress_field_label }}</span>
														</template>
														<el-input class="bpa-form-control" :placeholder="form_fields.bookingpress_field_placeholder" type="textarea" :rows="3" v-model="appointment_formdata.bookingpress_appointment_meta_fields_value[form_fields.bookingpress_field_meta_key]"></el-input>
													</el-form-item>									
													<el-form-item v-if="form_fields.bookingpress_field_type == 'checkbox'" :prop="form_fields.bookingpress_field_meta_key">
														<template #label>
															<span class="bpa-form-label">{{ form_fields.bookingpress_field_label }}</span>
														</template>
														<el-checkbox-group v-model="appointment_formdata.bookingpress_appointment_meta_fields_value[form_fields['bookingpress_field_meta_key']]">
															<el-checkbox class="bpa-front-label bpa-custom-checkbox--is-label" v-for="(chk_data, keys) in JSON.parse( form_fields.bookingpress_field_values)" :label="chk_data.value" :key="chk_data.value" :name="form_fields['bookingpress_field_meta_key']"><p v-html="chk_data.label"></p></el-checkbox>
														</el-checkbox-group>
													</el-form-item>
													<el-form-item v-if="form_fields.bookingpress_field_type == 'radio'" :prop="form_fields.bookingpress_field_meta_key">
														<template #label>
															<span class="bpa-form-label">{{ form_fields.bookingpress_field_label }}</span>
														</template>
														<el-radio class="bpa-form-label bpa-custom-radio--is-label" v-for="(chk_data, keys) in JSON.parse(form_fields.bookingpress_field_values)" :label="chk_data.label" :key="chk_data.value" v-model="appointment_formdata.bookingpress_appointment_meta_fields_value[form_fields.bookingpress_field_meta_key]">{{chk_data.label}}</el-radio>
													</el-form-item>
													<el-form-item v-if='form_fields.bookingpress_field_type == "dropdown"' :prop="form_fields.bookingpress_field_meta_key">
														<template #label>
															<span class="bpa-form-label">{{ form_fields.bookingpress_field_label }}</span>
														</template>
														<el-select class="bpa-form-control" :placeholder="form_fields.bookingpress_field_placeholder" v-model="appointment_formdata.bookingpress_appointment_meta_fields_value[form_fields.bookingpress_field_meta_key]">
															<el-option v-for="sel_data in JSON.parse(form_fields.bookingpress_field_values)" :key="sel_data.value" :label="sel_data.label" :value="sel_data.value"></el-option>
														</el-select>
													</el-form-item>
													<el-form-item v-if='form_fields.bookingpress_field_type == "date"' :prop="form_fields.bookingpress_field_meta_key">
														<template #label>
															<span class="bpa-form-label">{{ form_fields.bookingpress_field_label }}</span>
														</template>
														<el-date-picker :format="( 'true' == form_fields.bookingpress_field_options.enable_timepicker ) ? '<?php echo esc_html( $bookingpress_common_datetime_format ); ?>' : '<?php echo esc_html( $bookingpress_common_date_format ) ?>'" class="bpa-form-control bpa-form-control--date-picker" v-model="appointment_formdata.bookingpress_appointment_meta_fields_value[form_fields.bookingpress_field_meta_key]" prefix-icon="" :placeholder="form_fields.bookingpress_field_placeholder" :type="('true' == form_fields.bookingpress_field_options.enable_timepicker) ? 'datetime' : 'date'" :value-format="form_fields.bookingpress_field_options.enable_timepicker == 'true' ? 'yyyy-MM-dd hh:mm:ss' : 'yyyy-MM-dd'" :picker-options="filter_pickerOptions"></el-date-picker> <!-- @change="bookingpress_custom_field_date_change($event,form_fields.bookingpress_field_meta_key,form_fields.bookingpress_field_options.enable_timepicker)" -->
													</el-form-item>
													<el-form-item v-if='form_fields.bookingpress_field_type == "file"' :prop="form_fields.bookingpress_field_meta_key">
														<template #label>
															<span class="bpa-form-label">{{ form_fields.bookingpress_field_label }}</span>
														</template> 
														<el-upload class="bpa-form-control" :action="form_fields.bpa_action_url" :ref="form_fields.bpa_ref_name" :data="form_fields.bpa_action_data" v-model="appointment_formdata.bookingpress_appointment_meta_fields_value[form_fields.bookingpress_field_meta_key]" :on-success="BPACustomerFileUpload" :on-remove="BPACustomerFileUploadRemove" :file-list="form_fields.bpa_file_list" :on-error="BPACustomerFileUploadError" multiple="false" limit="1" :name="form_fields.bookingpress_field_meta_key" >
															<label for="bpa-file-upload-two" class="bpa-form-control--file-upload" >
																<span class="bpa-fu__placeholder">Choose a file...</span>
																<span class="bpa-fu__btn">Browse</span>
															</label> 
														</el-upload>
													</el-form-item>
												</div>
											</div>
										</el-col>
									</el-row>
								</div>
							</template>
						</el-form>	
					</div>
				</el-col>
			</el-row>
		</div>
		<?php 
		if ( $BookingPressPro->bookingpress_check_capability( 'bookingpress_payments' ) ) {
		?>
		<div class="bpa-form-row">
			<el-row>
				<el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
					<div class="bpa-db-sec-heading">
						<el-row type="flex" align="middle">
							<el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
								<div class="db-sec-left">
									<h2 class="bpa-page-heading"><?php esc_html_e( 'Payment Details', 'bookingpress-appointment-booking' ); ?></h2>
								</div>
							</el-col>
						</el-row>
					</div>
					<div class="bpa-default-card bpa-db-card">
						<div class="bpa-aaf--payment-details">
							<div class="bpa-aaf-pd__base-price-row">
								<div class="bpa-bpr__item">
									<h4>
										<?php esc_html_e('Subtotal', 'bookingpress-appointment-booking'); ?> 
										<span v-if="appointment_formdata.selected_bring_members > 1">(<?php esc_html_e('No. Of Person', 'bookingpress-appointment-booking'); ?> x {{ appointment_formdata.selected_bring_members }})</span>
									</h4>
									<h4>{{ appointment_formdata.subtotal_with_currency }}</h4>
								</div>
								<div class="bpa-bpr__item" v-if="bookingpress_is_extra_enable == '1'">
									<h4><?php esc_html_e('Service Extras', 'bookingpress-appointment-booking'); ?></h4>
									<h4>{{ appointment_formdata.extras_total_with_currency }}</h4>
								</div>
								<div class="bpa-bpr__item" v-if="appointment_formdata.tax != '0' && (appointment_formdata.tax_price_display_options != 'include_taxes' || (appointment_formdata.tax_price_display_options == 'include_taxes' && appointment_formdata.display_tax_order_summary == 'true'))">
									<h4><?php esc_html_e('Tax', 'bookingpress-appointment-booking'); ?></h4>
									<h4>+{{ appointment_formdata.tax_with_currency }}</h4>
								</div>								
							</div>
							<div class="bpa-aaf-pd__coupon-module" v-if="is_coupon_enable == 1">
								<div class="bpa-aaf--bs__coupon-module-textbox" v-if="is_coupon_enable == '1' && coupon_applied_status != 'success'">
									<el-row>
										<el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
											<span class="bpa-form-label"><?php esc_html_e( 'Have a coupon code?', 'bookingpress-appointment-booking' ); ?></span>
											<el-input class="bpa-form-control" v-model="appointment_formdata.applied_coupon_code" placeholder="<?php esc_html_e( 'Enter your coupon code', 'bookingpress-appointment-booking' ); ?>" :disabled="bpa_coupon_apply_disabled"></el-input>
											<div class="bpa-bs__coupon-validation --is-error" v-if="coupon_applied_status == 'error' && coupon_code_msg != ''">
												<span class="material-icons-round">error_outline</span>
												<p>{{ coupon_code_msg }}</p>
											</div>
											<div class="bpa-bs__coupon-validation --is-success" v-if="coupon_applied_status == 'success' && coupon_code_msg != ''">
												<span class="material-icons-round">check_circle</span>
												<p>{{ coupon_code_msg }}</p>
											</div>
											<el-button class="bpa-btn bpa-btn__medium bpa-btn--primary" @click="bookingpress_apply_coupon_code" :disabled="bpa_coupon_apply_disabled">
												<span class="bpa-btn__label" v-if="bpa_coupon_apply_disabled == 0"><?php esc_html_e( 'Apply', 'bookingpress-appointment-booking' ); ?></span>
												<span class="bpa-btn__label" v-else><?php esc_html_e( 'Applied', 'bookingpress-appointment-booking' ); ?></span>
												<div class="bpa-btn--loader__circles">
													<div></div>
													<div></div>
													<div></div>
												</div>
											</el-button>
										</el-col>
									</el-row>
								</div>
								<div class="bpa-fm--bs-amount-item bpa-is-coupon-applied bpa-is-hide-stroke" v-if="is_coupon_enable == '1' && coupon_applied_status == 'success'">
									<el-row>
										<el-col :xs="24" :sm="24" :md="24" :lg="22" :xl="22">
											<h4>
												<?php esc_html_e( 'Coupon Applied', 'bookingpress-appointment-booking' ); ?>
												<span>{{ appointment_formdata.applied_coupon_code }}<a class="material-icons-round" @click="bookingpress_remove_coupon_code">close</a></span>		
											</h4>
										</el-col>
										<el-col :xs="24" :sm="24" :md="24" :lg="2" :xl="2">
											<h4 class="is-price">-{{ appointment_formdata.coupon_discounted_amount_with_currency }}</h4>
										</el-col>
									</el-row>
								</div>
							</div>
							<!-- for tip addon add do_action for fornt-end add appointment -->
							<?php do_action('bookingpress_add_content_after_subtotal_data_backend'); ?>
							<div class="bpa-aaf-pd__base-price-row bpa-aaf-pd__total-row">
								<div class="bpa-bpr__item">
									<h4><?php esc_html_e('Total', 'bookingpress-appointment-booking'); ?> <span v-if="appointment_formdata.tax_price_display_options == 'include_taxes'">{{ appointment_formdata.included_tax_label }}</span></h4>
									<h4 class="bpa-text--primary-color">{{ appointment_formdata.total_amount_with_currency }}</h4>
								</div>								
							</div>
							<div class="bpa-aaf-pd__mark-paid-checkbox" v-if="(appointment_formdata.appointment_update_id == '')">
								<div>
									<h4><?php esc_html_e('Once appointment booked', 'bookingpress-appointment-booking'); ?></h4>
									<el-radio v-model="appointment_formdata.complete_payment_url_selection" label="send_payment_link"><?php esc_html_e( 'Send Payment Link', 'bookingpress-appointment-booking' ); ?></el-radio>
									<el-radio v-model="appointment_formdata.complete_payment_url_selection" label="mark_as_paid"><?php esc_html_e( 'Mark as paid', 'bookingpress-appointment-booking' ); ?></el-radio>
									<el-radio v-model="appointment_formdata.complete_payment_url_selection" label="do_nothing"><?php esc_html_e( 'Do Nothing', 'bookingpress-appointment-booking' ); ?></el-radio>
								</div>

								<div class="bpa-aaf-pd__custom-link-itemns" v-if="appointment_formdata.complete_payment_url_selection == 'send_payment_link'">
									<el-checkbox-group v-model="appointment_formdata.complete_payment_url_selected_method">
										<el-checkbox class="bpa-front-label bpa-custom-checkbox--is-label" label="email"><?php esc_html_e( 'Through Email', 'bookingpress-appointment-booking' ); ?></el-checkbox>
										<?php
											do_action('bookingpress_add_more_complete_payment_link_option');
										?>
									</el-checkbox-group>
								</div>
							</div>
						</div>
					</div>
				</el-col>
			</el-row>
		</div>
		<?php  } ?>
	</div>
</el-dialog>

<el-dialog id="customer_add_modal" custom-class="bpa-dialog bpa-dialog--fullscreen bpa-dialog--customer-modal bpa--is-page-scrollable-tablet" modal-append-to-body=false :visible.sync="open_customer_modal" :before-close="closeCustomerModal" fullscreen=true :close-on-press-escape="close_modal_on_esc">
    <div class="bpa-dialog-heading">
        <el-row type="flex">
            <el-col :xs="12" :sm="12" :md="16" :lg="16" :xl="16">
        <h1 class="bpa-page-heading" v-if="customer.update_id == 0"><?php esc_html_e('Add Customer', 'bookingpress-appointment-booking'); ?></h1>
        <h1 class="bpa-page-heading" v-else><?php esc_html_e('Edit Customer', 'bookingpress-appointment-booking'); ?></h1>
            </el-col>
            <el-col :xs="12" :sm="12" :md="7" :lg="7" :xl="7" class="bpa-dh__btn-group-col">
                <el-button class="bpa-btn bpa-btn--primary " :class="is_display_save_loader == '1' ? 'bpa-btn--is-loader' : ''" @click="saveCustomerDetails" :disabled="is_disabled" >
                    <span class="bpa-btn__label"><?php esc_html_e('Save', 'bookingpress-appointment-booking'); ?></span>
                    <div class="bpa-btn--loader__circles">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </el-button> 
                <el-button class="bpa-btn" @click="closeCustomerModal()"><?php esc_html_e('Cancel', 'bookingpress-appointment-booking'); ?></el-button>
            </el-col>
        </el-row>
    </div>
    
    <div class="bpa-dialog-body">
        <div class="bpa-back-loader-container" v-if="is_display_loader == '1'">
            <div class="bpa-back-loader"></div>
        </div>
        <div class="bpa-form-row">
            <el-row>
                <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                    <div class="bpa-db-sec-heading">
                        <el-row type="flex" align="middle">
                            <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                                <div class="db-sec-left">
                                    <h2 class="bpa-page-heading"><?php esc_html_e('Basic Details', 'bookingpress-appointment-booking'); ?></h2>
                                </div>
                            </el-col>
                            <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                                <div class="bpa-hw-right-btn-group">
                                    <el-button class="bpa-btn bpa-btn--icon-without-box __is-label" @click="openNeedHelper('list_customers', 'customers', 'Customers')">
                                        <span class="material-icons-round">help</span>
                                        <?php esc_html_e('Need help?', 'bookingpress-appointment-booking'); ?>
                                    </el-button>
                                </div>
                            </el-col>
                        </el-row>
                    </div>            
                    <div class="bpa-default-card bpa-db-card">
                        <el-form ref="customer" :rules="customer_rules" :model="customer" label-position="top" @submit.native.prevent>
                            <template>                            
                                <el-row :gutter="24">
                                    <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24" class="bpa-form-group">
                                        <el-upload class="bpa-upload-component" ref="avatarRef" action="<?php echo wp_nonce_url($bookingpress_ajaxurl . '?action=bookingpress_upload_customer_avatar', 'bookingpress_upload_customer_avatar'); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped --Reason - esc_html is already used by wp_nonce_url function and it's false positive ?>" :on-success="bookingpress_upload_customer_avatar_func" :file-list="customer.avatar_list" multiple="false" :show-file-list="cusShowFileList" limit="1" :on-exceed="bookingpress_image_upload_limit" :on-error="bookingpress_image_upload_err" :on-remove="bookingpress_remove_customer_avatar" :before-upload="checkUploadedFile" drag>
                                            <span class="material-icons-round bpa-upload-component__icon">cloud_upload</span>
                                           <div class="bpa-upload-component__text" v-if="customer.avatar_url == ''"><?php esc_html_e('jpg/png files with a size less than 500kb', 'bookingpress-appointment-booking'); ?>                                           
                                           </div>
                                        </el-upload>
                                        <div class="bpa-uploaded-avatar__preview"  v-if="customer.avatar_url != ''">
                                            <button class="bpa-avatar-close-icon" @click="bookingpress_remove_customer_avatar">
                                                <span class="material-icons-round">close</span>
                                            </button>
                                            <el-avatar shape="square" :src="customer.avatar_url" class="bpa-uploaded-avatar__picture"></el-avatar>
                                        </div>
                                    </el-col>
                                </el-row>
                                <div class="bpa-form-body-row bpa-fbr--customer">
                                    <el-row :gutter="32" type="flex">
                                        <el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8">
                                            <el-form-item prop="wp_user">
                                                <template #label>
                                                    <span class="bpa-form-label"><?php esc_html_e('WordPress User', 'bookingpress-appointment-booking'); ?></span>
                                                </template>
												<el-select class="bpa-form-control" v-model="customer.wp_user" filterable placeholder="<?php esc_html_e( 'Start typing to fetch user.', 'bookingpress-appointment-booking' ); ?>" @change="bookingpress_get_existing_user_details($event)"  remote reserve-keyword	 :remote-method="get_wordpress_users" :loading="bookingpress_loading">
													<el-option-group label="<?php esc_html_e( 'Create New User', 'bookingpress-appointment-booking' ); ?>">
														<template>
															<el-option value="add_new" label="Create New">
																<i class="el-icon-plus" ></i>
																<span><?php esc_html_e( 'Create New', 'bookingpress-appointment-booking' ); ?></span>
															</el-option>
														</template>
													</el-option-group>
													<el-option-group v-for="wp_user_list_cat in wpUsersList" :key="wp_user_list_cat.category" :label="wp_user_list_cat.category">
														<template>
															<el-option v-for="item in wp_user_list_cat.wp_user_data" :key="item.wp_user" :label="item.label" :value="item.value" >
																<span>{{ item.label }}</span>
															</el-option>
														</template>
													</el-option-group>
												</el-select>
                                            </el-form-item>                                                
                                        </el-col>                                        
                                        <el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8" v-if="customer.wp_user =='add_new'">
                                            <el-form-item>
                                                <template #label>
                                                    <span class="bpa-form-label"><?php esc_html_e('Password', 'bookingpress-appointment-booking'); ?></span>
                                                </template>
                                                <el-input class="bpa-form-control --bpa-fc-field-pass" type="password" v-model="customer.password" placeholder="<?php esc_html_e('Enter Password', 'bookingpress-appointment-booking'); ?>" :show-password="true" ></el-input>
                                            </el-form-item>                                            
                                        </el-col>
                                            <el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8">
                                            <el-form-item prop="firstname">
                                                <template #label>
                                                    <span class="bpa-form-label"><?php esc_html_e('First Name', 'bookingpress-appointment-booking'); ?></span>
                                                </template>
                                                <el-input class="bpa-form-control" v-model="customer.firstname" id="firstname" name="firstname" placeholder="<?php esc_html_e('Enter First Name', 'bookingpress-appointment-booking'); ?>"></el-input>
                                            </el-form-item>
                                        </el-col>
                                        <el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8">
                                            <el-form-item prop="lastname">
                                                <template #label>
                                                    <span class="bpa-form-label"><?php esc_html_e('Last Name', 'bookingpress-appointment-booking'); ?></span>
                                                </template>
                                                <el-input class="bpa-form-control" v-model="customer.lastname" id="lastname" name="lastname" placeholder="<?php esc_html_e('Enter Last Name', 'bookingpress-appointment-booking'); ?>"></el-input>
                                            </el-form-item>
                                        </el-col>                                            
                                        <el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8">
                                            <el-form-item prop="email">
                                                <template #label>
                                                    <span class="bpa-form-label"><?php esc_html_e('Email', 'bookingpress-appointment-booking'); ?></span>
                                                </template>
                                                <el-input class="bpa-form-control" v-model="customer.email" id="email" name="email" placeholder="<?php esc_html_e('Enter Email', 'bookingpress-appointment-booking'); ?>"></el-input>
                                            </el-form-item>
                                        </el-col>
                                        <el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8">
                                            <el-form-item prop="phone">
                                                <template #label>
                                                    <span class="bpa-form-label"><?php esc_html_e('Phone', 'bookingpress-appointment-booking'); ?></span>
                                                </template>
                                                <vue-tel-input v-model="customer.phone" class="bpa-form-control --bpa-country-dropdown" @country-changed="bookingpress_phone_country_change_func($event)" v-bind="bookingpress_tel_input_props" ref="bpa_tel_input_field">
                                                    <template v-slot:arrow-icon>
                                                        <span class="material-icons-round">keyboard_arrow_down</span>
                                                    </template>
                                                </vue-tel-input>
                                            </el-form-item>
                                        </el-col>            
                                        <el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8">
                                            <el-form-item prop="note">
                                                <template #label>
                                                    <span class="bpa-form-label"><?php esc_html_e('Note', 'bookingpress-appointment-booking'); ?></span>
                                                </template>
                                                <el-input class="bpa-form-control" type="textarea" :rows="3" v-model="customer.note"></el-input>
                                            </el-form-item>
                                        </el-col> 
										<el-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8" v-if="bookingpress_customer_fields.length > 0" :data-customer-field-id="bpa_cus_field.bookingpress_form_field_id" v-for="(bpa_cus_field, cfkey) in bookingpress_customer_fields">
											<el-form-item :prop="bpa_cus_field.bookingpress_field_meta_key">
												<template #label>
													<span class="bpa-form-label">{{bpa_cus_field.bookingpress_field_label}}</span>
												</template>
												<el-input class="bpa-form-control" v-model="customer['bpa_customer_field'][bpa_cus_field.bookingpress_field_meta_key]" :placeholder="bpa_cus_field.bookingpress_field_placeholder" v-if="'text' == bpa_cus_field.bookingpress_field_type"></el-input>
												<el-input class="bpa-form-control" :placeholder="bpa_cus_field.bookingpress_field_placeholder" v-model="customer['bpa_customer_field'][bpa_cus_field.bookingpress_field_meta_key]" v-if="'textarea' == bpa_cus_field.bookingpress_field_type" type="textarea"></el-input>
												<template v-if="'checkbox' == bpa_cus_field.bookingpress_field_type">
													<el-checkbox v-model="customer['bpa_customer_field'][bpa_cus_field.bookingpress_field_meta_key+'_'+keys]" class="bpa-form-label bpa-custom-checkbox--is-label" v-for="(chk_data,keys) in bpa_cus_field.bookingpress_field_values" :label="chk_data.label" :key="chk_data.value">{{chk_data.value}}</el-checkbox>
												</template>
												<template v-if="'radio' == bpa_cus_field.bookingpress_field_type">
													<el-radio v-model="customer['bpa_customer_field'][bpa_cus_field.bookingpress_field_meta_key]" class="bpa-form-label bpa-custom-radio--is-label" v-for="(rdo_data,keys) in bpa_cus_field.bookingpress_field_values" :label="rdo_data.label" :key="rdo_data.value">{{rdo_data.value}}</el-radio>
												</template>
												<template v-if="'dropdown' == bpa_cus_field.bookingpress_field_type">
													<el-select  v-model="customer['bpa_customer_field'][bpa_cus_field.bookingpress_field_meta_key]" class="bpa-form-control" :placeholder="bpa_cus_field.bookingpress_field_placeholder">
														<el-option v-for="sel_data in bpa_cus_field.bookingpress_field_values" :key="sel_data.value" :label="sel_data.label" :value="sel_data.value" ></el-option>
													</el-select>
												</template>
												<el-date-picker  :format="( 'true' == bpa_cus_field.bookingpress_field_options.enable_timepicker ) ? '<?php echo esc_html( $bookingpress_common_datetime_format ); ?>' : '<?php echo esc_html( $bookingpress_common_date_format ) ?>'" :placeholder="bpa_cus_field.bookingpress_field_placeholder" v-model="customer['bpa_customer_field'][bpa_cus_field.bookingpress_field_meta_key]" class="bpa-form-control bpa-form-control--date-picker" prefix-icon="" v-if="'date' == bpa_cus_field.bookingpress_field_type || 'datepicker' == bpa_cus_field.bookingpress_field_type" :type="'true' == bpa_cus_field.bookingpress_field_options.enable_timepicker ? 'datetime' : 'date'" :placeholder="bpa_cus_field.placeholder" :value-format="bpa_cus_field.bookingpress_field_options.enable_timepicker == 'true' ? 'yyyy-MM-dd hh:mm:ss' : 'yyyy-MM-dd'" :picker-options="filter_pickerOptions"></el-date-picker> <!-- @change="bpa_get_customer_formatted_date($event, bpa_cus_field.bookingpress_field_meta_key,bpa_cus_field.bookingpress_field_options.enable_timepicker)" -->
											</el-form-item>
										</el-col>
                                    </el-row>
                                </div>
                            </template>
                        </el-form>
                    </div>
                </el-col>
            </el-row>
        </div>
    </div>
</el-dialog>
