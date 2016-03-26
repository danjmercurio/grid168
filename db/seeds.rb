# This file should contain all the record creation needed to seed the database with its default values.
# The data can then be loaded with the rake db:seed (or created alongside the db with db:setup).
#
# Examples:
#
#   cities = City.create([{ name: 'Chicago' }, { name: 'Copenhagen' }])
#   Mayor.create(name: 'Emanuel', city: cities.first)
puts "Creating Outlet Type controlled vocabulary"
['Broadcast Network','Cable Network','Cable System',
'Full Power TV Station', 'Interconnect', 'Low Power - Cable',
'Sports Network', 'Subchannel Network', 'Telco'].each do |type|
	OutletType.create(:name => type)
end
puts 'Creating Programmer Types controlled vocabulary'
['DRTV', 'General', 'Home Shopping', 'Paid Religion', 'Programmer'].each do |type|
	ProgrammerType.create(:name => type)
end


puts "Create Sub channel type data.."
%w(DT1 DT2 DT3 DT4 DT5).each do |type|
	SubChannelType.create! name: type
end

puts "Create user admin and test.."
admin = User.create email: "admin@gmail.com",
						password: "adminadmin",
						password_confirmation: "adminadmin",
						phone: "012121212",
						title: "Admin user",
						first_name: "admin",
						last_name: "user"

admin.admin = true
admin.save
puts "User admin: admin@gmail.com, pass: adminadmin"

test = User.create email: "test@gmail.com",
						password: "111111",
						password_confirmation: "111111",
						phone: "012121212",
						title: "Test user",
						first_name: "test",
						last_name: "user"
puts "User test: test@gmail.com, pass: 111111"

puts "Create outlet sample.."
outlet1 = admin.outlets.create name: "WAST",
										subs: 50000,
										dma_id: 1,
										outlet_type_id: 2,
										first_name: "WAST",
										last_name: "TV",
										phone_number: "123455677"
outlet2 = admin.outlets.create name: "WABC",
										subs: 75000,
										dma_id: 2,
										outlet_type_id: 3,
										first_name: "WABC",
										last_name: "TV",
										phone_number: "123455677"
outlet3 = test.outlets.create name: "WACE",
										subs: 100000,
										dma_id: 3,
										outlet_type_id: 1,
										first_name: "WAST",
										last_name: "TV",
										phone_number: "123455677"
outlet1.save
outlet2.save
outlet3.save

puts "Create programmer sample.."
programmer1 = admin.programmers.create name: "Gem Shopping",
																						first_name: "gem",
																						last_name: "shopping",
																						email: "gem@gmail.com",
																						phone: "12341234"

programmer2 = admin.programmers.create name: "Grace to you",
																						first_name: "grace",
																						last_name: "show",
																						email: "grace@gmail.com",
																						phone: "12341234"

programmer3 = test.programmers.create name: "Disney channel",
																					first_name: "disney",
																					last_name: "show",
																					email: "disney@gmail.com",
																					phone: "12341234"

puts "Create offer sample.."
offer1 = outlet1.offers.create yearly_offer: 1,
										monthly_offer: 1,
										weekly_offer: 1,
										hourly_rate: 1,
										total_hours: 1,
										dollar_amount: 1,
										user_id: 1
offer1.half_hour_clicked = "monday_00.00;tuesday_00.00"
offer1.programmer_ids = [1, 2]
offer1.save

offer2 = outlet3.offers.create yearly_offer: 2,
										monthly_offer: 2,
										weekly_offer: 2,
										hourly_rate: 2,
										total_hours: 2,
										dollar_amount: 2,
										user_id: 2
offer2.half_hour_clicked = "monday_00.00;tuesday_00.00"
offer2.programmer_ids = [2]
offer2.save

offer3 = outlet2.offers.create yearly_offer: 3,
										monthly_offer: 3,
										weekly_offer: 3,
										hourly_rate: 3,
										total_hours: 3,
										dollar_amount: 3,
										user_id: 1
offer3.half_hour_clicked = "monday_00.00;tuesday_00.00"
offer3.programmer_ids = [1]
offer3.save

puts "Create sub channel sample.."
sub_channel1 = outlet3.sub_channels.create name: "RE",
														subs: 10000,
														sub_channel_type_id: 2

outlet3.sub_channels.create name: "TD",
														subs: 10000,
														sub_channel_type_id: 3

puts "Create sub offer for sub channel sample.."
sub_offer1 = sub_channel1.sub_channel_offers.create yearly_offer: 4,
																				monthly_offer: 4,
																				weekly_offer: 4,
																				hourly_rate: 4,
																				total_hours: 4,
																				dollar_amount: 4,
																				user_id: 2
sub_offer1.half_hour_clicked = "monday_00.00;tuesday_00.00"
sub_offer1.programmer_ids = [3]
sub_offer1.save

puts "Create CSV sample.."
Rake::Task['database_values:insert'].invoke
