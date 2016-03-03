module OffersHelper
	
	def day_arr
		["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"]
	end	 

  def display_hour(hour)
     
    first_two = hour[0, 1]+hour[1, 1]
    last_two = hour[2, 1]+hour[3, 1]
    time = first_two+":"+last_two
	
	end #end display_hour method
	
	# convert day, time for hidden field tag offer form
	def convert_day_hour(day, time)
		str = day + "_" + time[0, 2] + "." + time[2, 2]		
	end #end convert_day_hour
	
	# check if hours contain day and hour
	def contain_day_hour(half_hour_clicked, day, hour)
		check = false
		# if hours
			# for hour_object in hours
				# if hour_object.compare(day, hour)
					# check = true
					# break
				# end
			# end #end for hour_object
		# end
		if half_hour_clicked
			arr = half_hour_clicked.split(";")
			arr.each do |child|
				if child == (day + "_" + hour)
					check = true
					break
				end #end if true
			end #end loop
		end #end if half_hour_clicked != null
		check
	end #end contain_day_hour method

end
